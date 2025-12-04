<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class TestStripeWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:test-webhook {order_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stripe Webhookのテスト用にPaymentIntentの状態を確認';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        $order = Order::find($orderId);
        
        if (!$order) {
            $this->error("注文ID {$orderId} が見つかりません");
            return 1;
        }
        
        $this->info("注文情報:");
        $this->line("  注文番号: {$order->order_number}");
        $this->line("  注文ステータスID: {$order->status_id}");
        $this->line("  決済ステータス: {$order->payment_status}");
        $this->line("  PaymentIntent ID: {$order->stripe_payment_intent_id}");
        
        if (!$order->stripe_payment_intent_id) {
            $this->warn("PaymentIntent IDが設定されていません");
            return 0;
        }
        
        // Stripe APIで状態を確認
        try {
            Stripe::setApiKey(config('services.stripe.secret_key'));
            
            $paymentIntent = PaymentIntent::retrieve($order->stripe_payment_intent_id);
            
            $this->newLine();
            $this->info("Stripe PaymentIntent情報:");
            $this->line("  ID: {$paymentIntent->id}");
            $this->line("  Status: {$paymentIntent->status}");
            $this->line("  Amount: " . number_format($paymentIntent->amount) . " 円");
            $this->line("  Created: " . date('Y-m-d H:i:s', $paymentIntent->created));
            
            if ($paymentIntent->latest_charge) {
                $this->line("  Charge ID: {$paymentIntent->latest_charge}");
            }
            
            $this->newLine();
            
            // ステータスに応じたメッセージ
            switch ($paymentIntent->status) {
                case 'requires_payment_method':
                    $this->comment("決済手段が必要です（カード情報未入力）");
                    break;
                case 'requires_confirmation':
                    $this->comment("決済の確認が必要です");
                    break;
                case 'requires_action':
                    $this->comment("追加のアクションが必要です（3Dセキュア等）");
                    break;
                case 'processing':
                    $this->comment("決済処理中です");
                    break;
                case 'requires_capture':
                    $this->comment("決済の確定が必要です");
                    break;
                case 'canceled':
                    $this->warn("キャンセルされました");
                    break;
                case 'succeeded':
                    $this->info("✓ 決済成功");
                    
                    if ($order->payment_status == 1 && $order->status_id == 1) {
                        $this->info("✓ DBの状態も正しく更新されています");
                    } else {
                        $this->warn("⚠ DBの状態が一致していません");
                        $this->warn("  期待値: payment_status=1, status_id=1");
                        $this->warn("  現在値: payment_status={$order->payment_status}, status_id={$order->status_id}");
                    }
                    break;
                default:
                    $this->line("Status: {$paymentIntent->status}");
            }
            
        } catch (\Exception $e) {
            $this->error("Stripe APIエラー: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
