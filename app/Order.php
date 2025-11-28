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
    ];

    protected $casts = [
        'total_price' => 'decimal:0',
        'shipping_fee' => 'decimal:0',
        'ordered_at' => 'datetime',
    ];

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
}
