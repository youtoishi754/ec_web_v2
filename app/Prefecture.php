<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    protected $table = 'm_prefectures';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * この都道府県の配送先
     */
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
