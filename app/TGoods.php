<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TGoods extends Model
{
    /**
     * テーブル名
     */
    protected $table = 't_goods';

    /**
     * 複数代入可能な属性
     */
    protected $fillable = [
        'un_id',
        'goods_number',
        'goods_name',
        'image_path',
        'goods_price',
        'tax_rate',
        'goods_stock',
        'category_id',
        'goods_detail',
        'intro_txt',
        'disp_flg',
        'delete_flg',
        'sales_start_at',
        'sales_end_at',
    ];

    /**
     * 日付として扱う属性
     */
    protected $dates = [
        'sales_start_at',
        'sales_end_at',
        'ins_date',
        'up_date',
    ];

    /**
     * タイムスタンプのカラム名をカスタマイズ
     */
    const CREATED_AT = 'ins_date';
    const UPDATED_AT = 'up_date';

    /**
     * お気に入りに登録しているユーザー
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany('App\User', 't_favorites', 'goods_id', 'user_id')->withTimestamps();
    }

    /**
     * 表示可能な商品のみを取得するスコープ
     */
    public function scopeDisplayable($query)
    {
        return $query->where('disp_flg', 1)->where('delete_flg', 0);
    }

    /**
     * 在庫があるかチェック
     */
    public function hasStock()
    {
        return $this->goods_stock > 0;
    }
}
