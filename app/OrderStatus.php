<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'm_order_statuses';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'rank',
    ];

    /**
     * このステータスの注文
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}
