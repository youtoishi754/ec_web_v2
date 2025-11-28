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
                            <input class="form-check-input" type="radio" name="payment_method_id" 
                                id="payment{{ $method->id }}" value="{{ $method->id }}"
                                {{ $loop->first ? 'checked' : '' }} required>
                            <label class="form-check-label" for="payment{{ $method->id }}">
                                {{ $method->name }}
                                @if($method->id == 1)
                                    <small class="text-muted">(即時決済)</small>
                                @elseif($method->id == 2)
                                    <small class="text-muted">(商品受取時に現金払い)</small>
                                @elseif($method->id == 3)
                                    <small class="text-muted">(後払い)</small>
                                @endif
                            </label>
                        </div>
                        @endforeach
                        
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i> 
                            <strong>注意:</strong> 現在は仮の支払い処理となっています。実際の決済は行われません。
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
                        <button type="submit" class="btn btn-primary btn-block" 
                            {{ $shippingAddresses->isEmpty() ? 'disabled' : '' }}>
                            <i class="fas fa-check"></i> 注文を確定する
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('orderForm').addEventListener('submit', function(e) {
    var btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 処理中...';
});
</script>
@endsection
