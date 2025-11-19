<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * カートに商品を追加
     */
    public function add(Request $request)
    {
        // バリデーション
        $rules = [
            'goods_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 商品情報を取得
        $goods = DB::table('t_goods')
            ->where('id', $request->goods_id)
            ->where('delete_flg', 0)
            ->first();

        if (!$goods) {
            return redirect()->back()->withErrors(['error' => '商品が見つかりません。']);
        }

        // 在庫チェック
        if ($goods->goods_stock < $request->quantity) {
            return redirect()->back()->withErrors(['error' => '在庫が不足しています。']);
        }

        // カート情報をセッションに保存
        $cart = session()->get('cart', []);

        // すでにカートに入っている商品の場合は数量を追加
        if (isset($cart[$goods->id])) {
            $newQuantity = $cart[$goods->id]['quantity'] + $request->quantity;
            
            // 在庫チェック
            if ($goods->goods_stock < $newQuantity) {
                return redirect()->back()->withErrors(['error' => '在庫が不足しています。']);
            }
            
            $cart[$goods->id]['quantity'] = $newQuantity;
        } else {
            // 新しい商品をカートに追加
            $cart[$goods->id] = [
                'goods_id' => $goods->id,
                'goods_name' => $goods->goods_name,
                'goods_price' => $goods->goods_price,
                'quantity' => $request->quantity,
                'goods_number' => $goods->goods_number,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'カートに商品を追加しました。');
    }

    /**
     * カートの内容を表示
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['goods_price'] * $item['quantity'];
        }

        return view('cart.index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    /**
     * カートから商品を削除
     */
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->goods_id])) {
            unset($cart[$request->goods_id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'カートから商品を削除しました。');
        }

        return redirect()->back()->withErrors(['error' => '商品が見つかりません。']);
    }

    /**
     * カートをクリア
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('goods_list')->with('success', 'カートをクリアしました。');
    }
}
