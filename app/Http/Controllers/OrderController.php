<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderDetail;
use App\OrderStatus;
use App\PaymentMethod;
use App\ShippingAddress;
use App\Prefecture;
use App\TGoods;

class OrderController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 注文履歴一覧
     */
    public function index()
    {
        $user = Auth::user();
        
        // ユーザーの注文履歴を取得（新しい順）
        $orders = Order::with(['orderDetails.goods', 'status', 'paymentMethod'])
            ->where('user_id', $user->id)
            ->orderBy('ordered_at', 'desc')
            ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * 注文詳細
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // 自分の注文のみ表示
        $order = Order::with(['orderDetails.goods', 'status', 'paymentMethod'])
            ->where('user_id', $user->id)
            ->findOrFail($id);
        
        return view('orders.show', compact('order'));
    }

    /**
     * 注文確認画面
     */
    public function confirm(Request $request)
    {
        $user = Auth::user();
        
        // カートの内容を取得（セッションから）
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'カートが空です');
        }
        
        // 商品情報を取得
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $goodsId => $quantity) {
            $goods = TGoods::find($goodsId);
            if ($goods && $goods->goods_stock >= $quantity) {
                $price = $goods->goods_price;
                $cartItems[] = [
                    'goods' => $goods,
                    'quantity' => $quantity,
                    'subtotal' => $price * $quantity,
                ];
                $subtotal += $price * $quantity;
            }
        }
        
        // 配送先を取得
        $shippingAddresses = ShippingAddress::where('user_id', $user->id)
            ->with('prefecture')
            ->get();
        
        // デフォルトの配送先
        $defaultAddress = $shippingAddresses->where('is_default', true)->first() 
            ?? $shippingAddresses->first();
        
        // 支払方法を取得
        $paymentMethods = PaymentMethod::active();
        
        // 送料（仮：全国一律500円、10000円以上で無料）
        $shippingFee = $subtotal >= 10000 ? 0 : 500;
        
        return view('orders.confirm', compact(
            'cartItems',
            'subtotal',
            'shippingFee',
            'shippingAddresses',
            'defaultAddress',
            'paymentMethods'
        ));
    }

    /**
     * 注文処理（仮の支払い処理を含む）
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:t_shipping_addresses,id',
            'payment_method_id' => 'required|exists:m_payment_methods,id',
        ]);
        
        $user = Auth::user();
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'カートが空です');
        }
        
        DB::beginTransaction();
        
        try {
            // 配送先情報を取得
            $shippingAddress = ShippingAddress::with('prefecture')
                ->where('user_id', $user->id)
                ->findOrFail($request->shipping_address_id);
            
            // 商品情報と合計金額を計算
            $cartItems = [];
            $subtotal = 0;
            
            foreach ($cart as $goodsId => $quantity) {
                $goods = TGoods::lockForUpdate()->find($goodsId);
                
                if (!$goods) {
                    throw new \Exception("商品が見つかりません (ID: {$goodsId})");
                }
                
                if ($goods->goods_stock < $quantity) {
                    throw new \Exception("{$goods->goods_name} の在庫が不足しています");
                }
                
                $cartItems[] = [
                    'goods' => $goods,
                    'quantity' => $quantity,
                ];
                
                $subtotal += $goods->goods_price * $quantity;
            }
            
            // 送料計算
            $shippingFee = $subtotal >= 10000 ? 0 : 500;
            
            // 注文を作成
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total_price' => $subtotal,
                'shipping_fee' => $shippingFee,
                'status_id' => 1, // 注文確定
                'payment_id' => $request->payment_method_id,
                'shipping_name' => $shippingAddress->name,
                'shipping_address' => $shippingAddress->full_address,
                'ordered_at' => now(),
            ]);
            
            // 注文明細を作成 & 在庫を減らす
            foreach ($cartItems as $item) {
                $goods = $item['goods'];
                $quantity = $item['quantity'];
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'goods_id' => $goods->id,
                    'goods_name' => $goods->goods_name,
                    'price' => $goods->goods_price,
                    'quantity' => $quantity,
                ]);
                
                // 在庫を減らす
                $goods->goods_stock -= $quantity;
                $goods->save();
            }
            
            // 仮の支払い処理
            $paymentResult = $this->processFakePayment($order, $request->payment_method_id);
            
            if ($paymentResult['success']) {
                // 支払い成功 → ステータスを更新
                if ($request->payment_method_id == 1) { // クレジットカード
                    $order->status_id = 2; // 入金確認済
                    $order->save();
                } elseif ($request->payment_method_id == 3) { // 銀行振込
                    // 振込の場合は入金待ち（ステータス1のまま）
                }
                // 代金引換の場合もステータス1のまま
            } else {
                throw new \Exception('支払い処理に失敗しました');
            }
            
            DB::commit();
            
            // カートをクリア
            session()->forget('cart');
            
            return redirect()->route('orders.complete', $order->id)
                ->with('success', '注文が完了しました');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('orders.confirm')
                ->with('error', '注文処理中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    /**
     * 注文完了画面
     */
    public function complete($id)
    {
        $user = Auth::user();
        
        $order = Order::with(['orderDetails.goods', 'status', 'paymentMethod'])
            ->where('user_id', $user->id)
            ->findOrFail($id);
        
        return view('orders.complete', compact('order'));
    }

    /**
     * 配送先管理画面
     */
    public function addresses()
    {
        $user = Auth::user();
        
        $addresses = ShippingAddress::where('user_id', $user->id)
            ->with('prefecture')
            ->get();
        
        $prefectures = Prefecture::all();
        
        return view('orders.addresses', compact('addresses', 'prefectures'));
    }

    /**
     * 配送先追加
     */
    public function addAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:8',
            'prefecture_id' => 'required|exists:m_prefectures,id',
            'city' => 'required|string|max:255',
            'address_line' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);
        
        $user = Auth::user();
        
        DB::beginTransaction();
        
        try {
            $address = ShippingAddress::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'postal_code' => $request->postal_code,
                'prefecture_id' => $request->prefecture_id,
                'city' => $request->city,
                'address_line' => $request->address_line,
                'phone' => $request->phone,
                'is_default' => $request->is_default ?? false,
            ]);
            
            if ($request->is_default) {
                $address->setAsDefault();
            }
            
            DB::commit();
            
            return redirect()->route('orders.addresses')
                ->with('success', '配送先を追加しました');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('orders.addresses')
                ->with('error', '配送先の追加に失敗しました');
        }
    }

    /**
     * 配送先削除
     */
    public function deleteAddress($id)
    {
        $user = Auth::user();
        
        $address = ShippingAddress::where('user_id', $user->id)
            ->findOrFail($id);
        
        $address->delete();
        
        return redirect()->route('orders.addresses')
            ->with('success', '配送先を削除しました');
    }

    /**
     * デフォルト配送先設定
     */
    public function setDefaultAddress($id)
    {
        $user = Auth::user();
        
        $address = ShippingAddress::where('user_id', $user->id)
            ->findOrFail($id);
        
        $address->setAsDefault();
        
        return redirect()->route('orders.addresses')
            ->with('success', 'デフォルト配送先を設定しました');
    }

    /**
     * 仮の支払い処理
     * 実際の決済APIに置き換える予定
     */
    private function processFakePayment($order, $paymentMethodId)
    {
        // 仮の処理：常に成功を返す
        // 実際の実装では以下のような処理を行う：
        // 1. クレジットカード → 決済API呼び出し
        // 2. 銀行振込 → 振込情報をメール送信
        // 3. 代金引換 → 配送業者への連携
        
        \Log::info('仮の支払い処理', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'payment_method_id' => $paymentMethodId,
            'total_amount' => $order->calculateGrandTotal(),
        ]);
        
        // TODO: 実際の決済処理を実装
        // 例: Stripe, PAY.JP, GMO Payment など
        
        return [
            'success' => true,
            'transaction_id' => 'FAKE-' . uniqid(),
            'message' => '仮の支払い処理が完了しました',
        ];
    }
}
