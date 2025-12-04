<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 't_orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'shipping_fee',
        'status_id',
        'payment_id',
        'shipping_name',
        'shipping_address',
        'ordered_at',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'payment_status',
        'payment_error_message',
    ];

    protected $casts = [
        'total_price' => 'decimal:0',
        'shipping_fee' => 'decimal:0',
        'ordered_at' => 'datetime',
    ];

    // 決済ステータス定数
    const PAYMENT_STATUS_PENDING = 0;    // 未決済
    const PAYMENT_STATUS_COMPLETED = 1;  // 決済完了
    const PAYMENT_STATUS_FAILED = 2;     // 決済失敗
    const PAYMENT_STATUS_REFUNDED = 3;   // 返金済み

    /**
     * 注文者（ユーザー）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 注文明細
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * 注文ステータス
     */
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    /**
     * 支払方法
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_id');
    }

    /**
     * 注文番号を生成
     */
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -8));
    }

    /**
     * 合計金額を計算（商品小計 + 送料）
     */
    public function calculateGrandTotal()
    {
        return $this->total_price + $this->shipping_fee;
    }

    /**
     * ステータスが変更可能かチェック
     */
    public function canChangeStatus()
    {
        // 配達完了以外は変更可能
        return $this->status_id < 5;
    }

    /**
     * 決済完了にする
     */
    public function markAsPaid($paymentIntentId, $chargeId = null)
    {
        $this->update([
            'payment_status' => self::PAYMENT_STATUS_COMPLETED,
            'stripe_payment_intent_id' => $paymentIntentId,
            'stripe_charge_id' => $chargeId,
            'payment_error_message' => null,
        ]);
    }

    /**
     * 決済失敗にする
     */
    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'payment_status' => self::PAYMENT_STATUS_FAILED,
            'payment_error_message' => $errorMessage,
        ]);
    }

    /**
     * 返金済みにする
     */
    public function markAsRefunded()
    {
        $this->update([
            'payment_status' => self::PAYMENT_STATUS_REFUNDED,
        ]);
    }

    /**
     * 決済ステータスのラベルを取得
     */
    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            self::PAYMENT_STATUS_PENDING => '未決済',
            self::PAYMENT_STATUS_COMPLETED => '決済完了',
            self::PAYMENT_STATUS_FAILED => '決済失敗',
            self::PAYMENT_STATUS_REFUNDED => '返金済み',
        ];

        return $labels[$this->payment_status] ?? '不明';
    }

    /**
     * 決済完了済みかチェック
     */
    public function isPaid()
    {
        return $this->payment_status === self::PAYMENT_STATUS_COMPLETED;
    }
}
