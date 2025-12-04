@extends('layouts.parents')

@section('title', '注文確認')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header mt-4 mb-4">注文確認</h1>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf
                
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">注文商品</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;">画像</th>
                                        <th>商品名</th>
                                        <th>単価</th>
                                        <th>数量</th>
                                        <th class="text-right">小計</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('public/product-image/dummy.png') }}" 
                                                alt="{{ $item['goods']->goods_name }}" 
                                                class="img-thumbnail" 
                                                style="width: 180px; height: 120px; object-fit: cover;">
                                        </td>
                                        <td>{{ $item['goods']->goods_name }}</td>
                                        <td>¥{{ number_format($item['goods']->goods_price) }}</td>
                                        <td>{{ $item['quantity'] }}</td>
                                        <td class="text-right">¥{{ number_format($item['subtotal']) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>小計:</strong></td>
                                        <td class="text-right">¥{{ number_format($subtotal) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>送料:</strong></td>
                                        <td class="text-right">
                                            ¥{{ number_format($shippingFee) }}
                                            @if($shippingFee == 0)
                                                <span class="badge badge-success">送料無料</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="table-active">
                                        <td colspan="4" class="text-right"><strong>合計:</strong></td>
                                        <td class="text-right"><strong>¥{{ number_format($subtotal + $shippingFee) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">配送先選択</h5>
                    </div>
                    <div class="card-body">
                        @if($shippingAddresses->isEmpty())
                            <div class="alert alert-warning">
                                配送先が登録されていません。<br>
                                <a href="{{ route('orders.addresses') }}" class="btn btn-sm btn-primary">配送先を登録する</a>
                            </div>
                        @else
                            @foreach($shippingAddresses as $address)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="shipping_address_id" 
                                    id="address{{ $address->id }}" value="{{ $address->id }}"
                                    {{ $defaultAddress && $defaultAddress->id == $address->id ? 'checked' : '' }}
                                    required>
                                <label class="form-check-label" for="address{{ $address->id }}">
                                    <strong>{{ $address->name }}</strong>
                                    @if($address->is_default)
                                        <span class="badge badge-primary">デフォルト</span>
                                    @endif
                                    <br>
                                    {{ $address->full_address }}<br>
                                    TEL: {{ $address->phone }}
                                </label>
                            </div>
                            @endforeach
                            
                            <a href="{{ route('orders.addresses') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-plus"></i> 新しい配送先を追加
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">支払方法選択</h5>
                    </div>
                    <div class="card-body">
                        @foreach($paymentMethods as $method)
                        <div class="form-check mb-2">
                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method_id" 
                                id="payment{{ $method->id }}" value="{{ $method->id }}"
                                data-method-type="{{ $method->id }}"
                                {{ $loop->first ? 'checked' : '' }} required>
                            <label class="form-check-label" for="payment{{ $method->id }}">
                                <strong>{{ $method->name }}</strong>
                                @if($method->id == 1)
                                    <small class="text-muted">(Stripeクレジットカード決済)</small>
                                @elseif($method->id == 2)
                                    <small class="text-muted">(商品受取時に現金払い)</small>
                                @elseif($method->id == 3)
                                    <small class="text-muted">(後払い - 入金確認後発送)</small>
                                @endif
                            </label>
                        </div>
                        @endforeach
                        
                        <!-- Stripeカード入力フォーム -->
                        <div id="stripe-card-section" class="mt-4" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-credit-card"></i> カード情報を入力してください
                            </div>
                            <div class="form-group">
                                <label>カード番号・有効期限・CVC</label>
                                <div id="card-element" class="form-control" style="height: 40px; padding: 10px;">
                                    <!-- Stripe Elementがここに挿入されます -->
                                </div>
                                <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                            </div>
                            <div class="alert alert-warning">
                                <strong>テストカード番号:</strong><br>
                                成功: 4242 4242 4242 4242<br>
                                失敗: 4000 0000 0000 0002<br>
                                有効期限: 将来の日付（例: 12/25）<br>
                                CVC: 任意の3桁（例: 123）
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-3" id="payment-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>入金確認後に発送いたします。</strong>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <a href="{{ route('cart') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> カートに戻る
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary btn-block" id="submit-button"
                            {{ $shippingAddresses->isEmpty() ? 'disabled' : '' }}>
                            <i class="fas fa-check"></i> 注文を確定する
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
// Stripe初期化
const stripe = Stripe('{{ env('STRIPE_TEST_PUBLIC_KEY') }}');
let elements;
let cardElement;

// 支払方法変更時の処理
document.querySelectorAll('.payment-method-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        const paymentMethodId = this.value;
        const stripeSection = document.getElementById('stripe-card-section');
        const paymentInfo = document.getElementById('payment-info');
        
        if (paymentMethodId === '1') { // クレジットカード
            stripeSection.style.display = 'block';
            paymentInfo.innerHTML = '<i class="fas fa-info-circle"></i> <strong>Stripe決済完了後、自動的に入金確認されます。</strong>';
            
            // Stripe Elementsを初期化（まだの場合）
            if (!elements) {
                initializeStripeElements();
            }
        } else {
            stripeSection.style.display = 'none';
            if (paymentMethodId === '2') { // 代引き
                paymentInfo.innerHTML = '<i class="fas fa-info-circle"></i> <strong>商品受取時に配達員にお支払いください。入金確認後に発送いたします。</strong>';
            } else if (paymentMethodId === '3') { // 銀行振込
                paymentInfo.innerHTML = '<i class="fas fa-info-circle"></i> <strong>振込確認後に発送いたします。振込先は注文完了画面に表示されます。</strong>';
            }
        }
    });
});

// Stripe Elements初期化
function initializeStripeElements() {
    elements = stripe.elements();
    cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
    });
    cardElement.mount('#card-element');
    
    // エラー表示
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
}

// ページ読み込み時に初期状態をチェック
document.addEventListener('DOMContentLoaded', function() {
    const checkedRadio = document.querySelector('.payment-method-radio:checked');
    if (checkedRadio && checkedRadio.value === '1') {
        document.getElementById('stripe-card-section').style.display = 'block';
        initializeStripeElements();
    }
});

// フォーム送信処理
document.getElementById('orderForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitButton = document.getElementById('submit-button');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 処理中...';
    
    const paymentMethodId = document.querySelector('.payment-method-radio:checked').value;
    
    try {
        // クレジットカード決済の場合
        if (paymentMethodId === '1') {
            // PaymentMethodを作成
            const {error: methodError, paymentMethod} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });
            
            if (methodError) {
                document.getElementById('card-errors').textContent = methodError.message;
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                return;
            }
            
            // PaymentMethod IDをフォームに追加
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'stripe_payment_method_id';
            input.value = paymentMethod.id;
            this.appendChild(input);
        }
        
        // フォームを送信
        this.submit();
        
    } catch (error) {
        console.error('Error:', error);
        alert('エラーが発生しました: ' + error.message);
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
});
</script>
@endsection
