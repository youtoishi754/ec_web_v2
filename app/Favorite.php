<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * テーブル名
     */
    protected $table = 't_favorites';

    /**
     * 複数代入可能な属性
     */
    protected $fillable = [
        'user_id',
        'goods_id',
    ];

    /**
     * お気に入りが属するユーザー
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * お気に入りが属する商品
     */
    public function goods()
    {
        return $this->belongsTo('App\TGoods', 'goods_id', 'id');
    }
}
