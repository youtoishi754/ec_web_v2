<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Order;
use App\Mail\OrderCompleteMail;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Stripeからのwebhookを処理
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        // Webhook Secretが設定されていない場合の警告
        if (empty($endpoint_secret)) {
            Log::error('Webhook Secret未設定', [
                'message' => 'STRIPE_WEBHOOK_SECRETが.envに設定されていません',
            ]);
            return response()->json(['error' => 'Webhook not configured'], 500);
        }

        // 署名ヘッダーがない場合
        if (empty($sig_header)) {
            Log::error('Webhook署名ヘッダーなし', [
                'message' => 'Stripe-Signatureヘッダーが存在しません',
            ]);
            return response()->json(['error' => 'No signature header'], 400);
        }

        try {
            // Webhookの署名を検証
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            Log::error('Webhook無効なペイロード', [
                'error' => $e->getMessage(),
                'payload_length' => strlen($payload),
            ]);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook署名検証失敗', [
                'error' => $e->getMessage(),
                'signature_header' => substr($sig_header, 0, 50) . '...',
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        Log::info('Webhook受信成功', [
            'event_id' => $event->id,
            'type' => $event->type,
            'created' => date('Y-m-d H:i:s', $event->created),
        ]);

        // イベントタイプに応じて処理
        try {
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->handlePaymentIntentSucceeded($event->data->object);
                    break;
                
                case 'payment_intent.payment_failed':
                    $this->handlePaymentIntentFailed($event->data->object);
                    break;
                
                case 'payment_intent.canceled':
                    $this->handlePaymentIntentCanceled($event->data->object);
                    break;
                
                case 'charge.refunded':
                    $this->handleChargeRefunded($event->data->object);
                    break;
                
                case 'charge.succeeded':
                    Log::info('Charge成功イベント受信（PaymentIntentで処理済み）', [
                        'charge_id' => $event->data->object->id,
                    ]);
                    break;

                default:
                    Log::info('未処理のWebhookイベント', [
                        'type' => $event->type,
                        'event_id' => $event->id,
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('Webhookイベント処理中にエラー発生', [
                'event_type' => $event->type,
                'event_id' => $event->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // エラーが発生してもStripeには成功を返す（リトライを防ぐ）
        }

        return response()->json(['received' => true], 200);
    }

    /**
     * 決済成功時の処理
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        Log::info('決済成功Webhook受信', [
            'payment_intent_id' => $paymentIntent->id,
            'amount' => $paymentIntent->amount,
            'status' => $paymentIntent->status,
        ]);

        // PaymentIntent IDから注文を検索
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$order) {
            Log::warning('注文が見つかりません', ['payment_intent_id' => $paymentIntent->id]);
            return;
        }

        // すでに処理済みの場合はスキップ
        if ($order->isPaid()) {
            Log::info('すでに決済完了済み', ['order_id' => $order->id]);
            return;
        }

        DB::beginTransaction();
        
        try {
            $oldStatusId = $order->status_id;
            
            // 決済完了処理
            $order->markAsPaid($paymentIntent->id, $paymentIntent->latest_charge);
            
            // 注文ステータスを更新（決済未完了(9) → 入金確認済(2)）
            $order->update([
                'status_id' => 2, // 入金確認済
            ]);

            DB::commit();

            Log::info('注文ステータスを入金確認済に更新', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'old_status_id' => $oldStatusId,
                'new_status_id' => 2,
                'payment_status' => Order::PAYMENT_STATUS_COMPLETED,
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_charge_id' => $paymentIntent->latest_charge,
            ]);

            // 決済完了通知メールを送信
            try {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderCompleteMail($order));
                    Log::info('決済完了通知メール送信成功', [
                        'order_id' => $order->id,
                        'email' => $order->user->email,
                    ]);
                }
            } catch (\Exception $e) {
                // メール送信失敗してもエラーにしない
                Log::error('決済完了通知メール送信失敗', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('決済成功処理でエラー発生', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntent->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 決済失敗時の処理
     */
    private function handlePaymentIntentFailed($paymentIntent)
    {
        $errorMessage = $paymentIntent->last_payment_error->message ?? 'Unknown error';
        
        Log::warning('決済失敗Webhook受信', [
            'payment_intent_id' => $paymentIntent->id,
            'error' => $errorMessage,
        ]);

        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$order) {
            Log::warning('注文が見つかりません（決済失敗）', ['payment_intent_id' => $paymentIntent->id]);
            return;
        }

        DB::beginTransaction();
        
        try {
            // 決済失敗を記録（status_idは9（決済未完了）のまま維持）
            $order->markAsFailed($errorMessage);

            DB::commit();

            Log::info('注文の決済失敗を記録', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status_id' => $order->status_id, // 決済未完了のまま
                'payment_status' => Order::PAYMENT_STATUS_FAILED,
                'error_message' => $errorMessage,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('決済失敗処理でエラー発生', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntent->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 返金時の処理
     */
    private function handleChargeRefunded($charge)
    {
        Log::info('返金Webhook受信', [
            'charge_id' => $charge->id,
            'amount_refunded' => $charge->amount_refunded,
            'refunded' => $charge->refunded,
        ]);

        $order = Order::where('stripe_charge_id', $charge->id)->first();

        if (!$order) {
            Log::warning('注文が見つかりません（返金）', ['charge_id' => $charge->id]);
            return;
        }

        DB::beginTransaction();
        
        try {
            // 返金処理
            $order->markAsRefunded();

            DB::commit();

            Log::info('注文を返金済みに更新', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'payment_status' => Order::PAYMENT_STATUS_REFUNDED,
                'amount_refunded' => $charge->amount_refunded,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('返金処理でエラー発生', [
                'order_id' => $order->id,
                'charge_id' => $charge->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 決済キャンセル時の処理
     */
    private function handlePaymentIntentCanceled($paymentIntent)
    {
        Log::info('決済キャンセルWebhook受信', [
            'payment_intent_id' => $paymentIntent->id,
            'status' => $paymentIntent->status,
            'cancellation_reason' => $paymentIntent->cancellation_reason ?? 'なし',
        ]);

        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$order) {
            Log::warning('注文が見つかりません（キャンセル）', ['payment_intent_id' => $paymentIntent->id]);
            return;
        }

        DB::beginTransaction();
        
        try {
            // キャンセル理由を記録
            $cancelReason = $paymentIntent->cancellation_reason ?? 'キャンセルされました';
            
            $order->update([
                'payment_status' => 4, // キャンセル
                'payment_error_message' => $cancelReason,
            ]);

            DB::commit();

            Log::info('注文をキャンセル済みに更新', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status_id' => $order->status_id,
                'payment_status' => 4,
                'cancel_reason' => $cancelReason,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('キャンセル処理でエラー発生', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntent->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
