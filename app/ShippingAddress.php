<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $table = 't_shipping_addresses';

    protected $fillable = [
        'user_id',
        'name',
        'postal_code',
        'prefecture_id',
        'city',
        'address_line',
        'phone',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * ユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 都道府県
     */
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    /**
     * 完全な住所を取得
     */
    public function getFullAddressAttribute()
    {
        $prefecture = $this->prefecture ? $this->prefecture->name : '';
        return "〒{$this->postal_code} {$prefecture}{$this->city}{$this->address_line}";
    }

    /**
     * デフォルト設定を更新
     */
    public function setAsDefault()
    {
        // 他のデフォルトを解除
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // このアドレスをデフォルトに
        $this->is_default = true;
        $this->save();
    }
}
