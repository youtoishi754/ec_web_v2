@extends('layouts.parents')
@section('title', 'カート')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item active" aria-current="page">カート</li>
    </ol>
  </nav>

  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">ショッピングカート</h3>

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(empty($cart))
    <div class="alert alert-info mt-4">
      カートに商品が入っていません。
    </div>
    <a href="{{ route('goods_list') }}" class="btn btn-primary">商品一覧へ</a>
  @else
    {{-- PC表示用テーブル --}}
    <div class="table-responsive mt-4 d-none d-md-block">
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th style="width: 200px;">画像</th>
            <th>商品番号</th>
            <th>商品名</th>
            <th>単価</th>
            <th>数量</th>
            <th>小計</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $item)
          <tr data-goods-id="{{ $item['goods_id'] }}" data-price="{{ $item['goods_price'] }}">
            <td>
              <img src="{{ asset('public/product-image/dummy.png') }}" alt="{{ $item['goods_name'] }}" class="img-thumbnail" style="width: 180px; height: 120px; object-fit: cover;">
            </td>
            <td>{{ $item['goods_number'] }}</td>
            <td>{{ $item['goods_name'] }}</td>
            <td class="unit-price">¥{{ number_format($item['goods_price']) }}</td>
            <td>
              <div class="d-flex align-items-center justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-secondary btn-decrease" data-goods-id="{{ $item['goods_id'] }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                  <i class="fas fa-minus"></i>
                </button>
                <span class="mx-3 quantity-display" data-goods-id="{{ $item['goods_id'] }}">{{ $item['quantity'] }}個</span>
                <button type="button" class="btn btn-sm btn-outline-secondary btn-increase" data-goods-id="{{ $item['goods_id'] }}">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </td>
            <td class="subtotal">¥{{ number_format($item['goods_price'] * $item['quantity']) }}</td>
            <td>
              <form action="{{ route('cart_remove') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="goods_id" value="{{ $item['goods_id'] }}">
                <button type="submit" class="btn btn-sm btn-danger">削除</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="5" class="text-right">合計</th>
            <th colspan="2" id="total-price">¥{{ number_format($total) }}</th>
          </tr>
        </tfoot>
      </table>
    </div>

    {{-- モバイル表示用カード --}}
    <div class="d-md-none mt-4">
      @foreach($cart as $item)
      <div class="card mb-3 cart-item-card" data-goods-id="{{ $item['goods_id'] }}" data-price="{{ $item['goods_price'] }}">
        <div class="row no-gutters">
          <div class="col-4">
            <img src="{{ asset('public/product-image/dummy.png') }}" alt="{{ $item['goods_name'] }}" class="img-fluid cart-mobile-img" style="width: 100%; height: 150px; object-fit: cover; border-radius: 0.25rem 0 0 0.25rem;">
          </div>
          <div class="col-8">
            <div class="card-body p-2">
              <h6 class="card-title mb-1">{{ $item['goods_name'] }}</h6>
              <p class="card-text small text-muted mb-1">商品番号: {{ $item['goods_number'] }}</p>
              <p class="card-text mb-2">
                <span class="text-danger font-weight-bold">¥{{ number_format($item['goods_price']) }}</span>
              </p>
              <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center">
                  <button type="button" class="btn btn-sm btn-outline-secondary btn-decrease" data-goods-id="{{ $item['goods_id'] }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                    <i class="fas fa-minus"></i>
                  </button>
                  <span class="mx-2 quantity-display" data-goods-id="{{ $item['goods_id'] }}">{{ $item['quantity'] }}個</span>
                  <button type="button" class="btn btn-sm btn-outline-secondary btn-increase" data-goods-id="{{ $item['goods_id'] }}">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
                <div class="subtotal font-weight-bold">¥{{ number_format($item['goods_price'] * $item['quantity']) }}</div>
              </div>
              <form action="{{ route('cart_remove') }}" method="POST">
                @csrf
                <input type="hidden" name="goods_id" value="{{ $item['goods_id'] }}">
                <button type="submit" class="btn btn-sm btn-danger btn-block">
                  <i class="fas fa-trash"></i> 削除
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      
      {{-- モバイル用合計表示 --}}
      <div class="card bg-light mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">合計金額</h5>
            <h4 class="mb-0 text-danger" id="total-price-mobile">¥{{ number_format($total) }}</h4>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-6">
        <a href="{{ route('goods_list') }}" class="btn btn-secondary btn-block">買い物を続ける</a>
      </div>
      <div class="col-md-6">
        <form action="{{ route('cart_clear') }}" method="POST" class="d-inline w-100">
          @csrf
          <button type="submit" class="btn btn-outline-danger btn-block" onclick="return confirm('カートをクリアしますか？')">カートをクリア</button>
        </form>
      </div>
    </div>

    <div class="mt-3">
      <button class="btn btn-success btn-lg btn-block" disabled>
        <i class="fas fa-credit-card"></i> レジに進む（未実装）
      </button>
    </div>
  @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // 数量増加ボタン
  document.querySelectorAll('.btn-increase').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const goodsId = this.getAttribute('data-goods-id');
      const quantityDisplay = document.querySelector('.quantity-display[data-goods-id="' + goodsId + '"]');
      const currentQuantity = parseInt(quantityDisplay.textContent);
      const newQuantity = currentQuantity + 1;
      
      updateQuantity(goodsId, newQuantity);
    });
  });
  
  // 数量減少ボタン
  document.querySelectorAll('.btn-decrease').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const goodsId = this.getAttribute('data-goods-id');
      const quantityDisplay = document.querySelector('.quantity-display[data-goods-id="' + goodsId + '"]');
      const currentQuantity = parseInt(quantityDisplay.textContent);
      
      if (currentQuantity > 1) {
        const newQuantity = currentQuantity - 1;
        updateQuantity(goodsId, newQuantity);
      }
    });
  });
  
  // 数量更新関数
  function updateQuantity(goodsId, newQuantity) {
    const row = document.querySelector('tr[data-goods-id="' + goodsId + '"]');
    const quantityDisplay = row.querySelector('.quantity-display');
    const subtotalCell = row.querySelector('.subtotal');
    const price = parseInt(row.getAttribute('data-price'));
    
    // 数量表示を更新
    quantityDisplay.textContent = newQuantity + '個';
    
    // 小計を更新
    const subtotal = price * newQuantity;
    subtotalCell.textContent = '¥' + subtotal.toLocaleString();
    
    // 減少ボタンの状態を更新
    const decreaseBtn = row.querySelector('.btn-decrease');
    if (newQuantity <= 1) {
      decreaseBtn.disabled = true;
    } else {
      decreaseBtn.disabled = false;
    }
    
    // 合計金額を更新
    updateTotal();
    
    // ヘッダーのカートバッジを更新
    updateCartBadge();
    
    // セッションを更新（ページリロード時に反映）
    updateCartSession(goodsId, newQuantity);
  }
  
  // 合計金額を再計算
  function updateTotal() {
    let total = 0;
    
    // PCとモバイル両方のカート要素を取得
    const cartRows = document.querySelectorAll('tbody tr, .cart-item-card');
    
    cartRows.forEach(function(row) {
      const price = parseInt(row.getAttribute('data-price'));
      const quantityText = row.querySelector('.quantity-display').textContent;
      const quantity = parseInt(quantityText);
      total += price * quantity;
    });
    
    // PC用の合計を更新
    const totalPriceElement = document.getElementById('total-price');
    if (totalPriceElement) {
      totalPriceElement.textContent = '¥' + total.toLocaleString();
    }
    
    // モバイル用の合計を更新
    const totalPriceMobileElement = document.getElementById('total-price-mobile');
    if (totalPriceMobileElement) {
      totalPriceMobileElement.textContent = '¥' + total.toLocaleString();
    }
  }
  
  // ヘッダーのカートバッジを更新
  function updateCartBadge() {
    let totalItems = 0;
    document.querySelectorAll('.quantity-display').forEach(function(display) {
      const quantity = parseInt(display.textContent);
      totalItems += quantity;
    });
    
    // ヘッダーのバッジを更新
    const badge = document.querySelector('.badge-danger');
    if (badge) {
      badge.textContent = totalItems;
    }
  }
  
  // セッションにカート情報を保存（Ajaxで非同期更新）
  function updateCartSession(goodsId, quantity) {
    // フォームデータを作成
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    formData.append('goods_id', goodsId);
    formData.append('quantity', quantity);
    
    // Fetchでセッション更新（エラーは無視してクライアント側のみ更新）
    fetch('{{ route("cart") }}', {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).catch(function(error) {
      // エラーは無視（クライアント側は既に更新済み）
      console.log('Session update failed, but client-side update is done');
    });
  }
});
</script>
@endsection
