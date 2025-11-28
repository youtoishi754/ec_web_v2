<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'm_payment_methods';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * 有効な支払方法のみ取得
     */
    public static function active()
    {
        return static::where('is_active', true)->get();
    }

    /**
     * この支払方法の注文
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_id');
    }
}
