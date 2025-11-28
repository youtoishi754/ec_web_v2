<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'last_name', 'first_name', 'last_name_kana', 'first_name_kana',
        'postal_code', 'prefecture', 'city', 'address', 'building',
        'phone', 'birthday', 'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 有効なユーザーのみ取得するスコープ
     */
    public function scopeActive($query)
    {
        return $query->where('delete_flg', 0);
    }

    /**
     * 削除済みかチェック
     */
    public function isDeleted()
    {
        return $this->delete_flg == 1;
    }

    /**
     * ユーザーのお気に入り
     */
    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * お気に入り登録している商品
     */
    public function favoriteGoods()
    {
        return $this->belongsToMany('App\TGoods', 't_favorites', 'user_id', 'goods_id')->withTimestamps();
    }

    /**
     * ユーザーの注文
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * ユーザーの配送先
     */
    public function shippingAddresses()
    {
        return $this->hasMany('App\ShippingAddress');
    }
}
