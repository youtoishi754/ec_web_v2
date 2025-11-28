<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 't_order_details';

    protected $fillable = [
        'order_id',
        'goods_id',
        'goods_name',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'quantity' => 'integer',
    ];

    /**
     * 注文
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * 商品
     */
    public function goods()
    {
        return $this->belongsTo(TGoods::class, 'goods_id');
    }

    /**
     * 小計を計算
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
