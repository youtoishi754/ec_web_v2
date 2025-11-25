@extends('layouts.parents')
@section('title', 'EC管理システム-新規登録')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">トップ</li>
      <li class="breadcrumb-item active" aria-current="page">商品一覧</li>
    </ol>
  </nav>
  {{-- 見出し --}}
  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">商品一覧</h3>
  <div class="list">

     <form method="get" class="form-inline mb-3">
      <label class="mr-2">並び替え</label>
      <select name="sort_by" class="form-control mr-2">
        <option value="insert" @if(request('sort_by') === 'insert') selected @endif>販売開始日時</option>
        <option value="price"  @if(request('sort_by') === 'price')  selected @endif>価格</option>
      </select>
      <select name="sort_direction" class="form-control mr-2">
        <option value="desc" @if(request('sort_direction') === 'desc') selected @endif>降順（新しい順 / 高い順）</option>
        <option value="asc"  @if(request('sort_direction') === 'asc')  selected @endif>昇順（古い順 / 安い順）</option>
      </select>
      {{-- 商品名検索--}}
      <div class="ml-2 d-flex align-items-center">
        <label for="goods_name" class="sr-only">商品名検索</label>
        <input type="text" id="goods_name" name="goods_name" value="{{ request('goods_name') }}" class="form-control mr-2"placeholder="商品名で検索">
      </div>
      <button type="submit" class="btn btn-primary">適用</button>
    </form>

    <!-- ページャーサマリー（ソート欄の下） -->
    <div class="row mt-2 mb-3 align-items-center">
      <div class="col-md-3 text-muted">
        表示 
        @if(isset($goods_list) && $goods_list instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $goods_list->firstItem() }} - {{ $goods_list->lastItem() }} /全 {{ $goods_list->total() }} 件
        @else
            0 - 0 /全 0 件
        @endif
      </div>
      <div class="col-md-6 text-right">
        {{ $goods_list->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
      </div>
    </div>
    <div class="row">
      {{-- 商品リスト --}}  
      @foreach ($goods_list as $goods)
      <div class="col-md-3 mb-4">
        <div class="card h-100">
          <a href="{{ route('goods_detail', ['un_id' => $goods->un_id]) }}" class="text-decoration-none">
            <img class="card-img-top" src="{{ asset('public/product-image/dummy.png') }}" alt="商品画像">
          </a>
          <div class="card-body d-flex flex-column position-relative">
            {{-- お気に入りボタン --}}
            @if(auth()->check())
              <button class="btn btn-sm btn-outline-warning favorite-btn-list position-absolute" 
                      style="top: 5px; right: 5px; z-index: 10; padding: 2px 6px;"
                      data-goods-id="{{ $goods->id }}" 
                      data-favorited="{{ auth()->user()->favoriteGoods->contains($goods->id) ? 'true' : 'false' }}">
                <i class="{{ auth()->user()->favoriteGoods->contains($goods->id) ? 'fas' : 'far' }} fa-star"></i>
              </button>
            @else
              <a href="{{ route('login') }}" class="btn btn-sm btn-outline-warning position-absolute" 
                 style="top: 5px; right: 5px; z-index: 10; padding: 2px 6px;">
                <i class="far fa-star"></i>
              </a>
            @endif
            
            <a href="{{ route('goods_detail', ['un_id' => $goods->un_id]) }}" class="text-decoration-none text-dark" style="padding-right: 35px;">
              <h5 class="card-title">{{ $goods->goods_name }}</h5>
            </a>
            <p class="card-text mb-1">価格: ¥{{ number_format($goods->goods_price) }}</p>
            <p class="card-text mb-1">在庫: {{ $goods->goods_stock }}個</p>
            
            @if($goods->goods_stock > 0)
              <form action="{{ route('cart_add') }}" method="POST" class="mt-auto mb-2">
                @csrf
                <input type="hidden" name="goods_id" value="{{ $goods->id }}">
                <input type="hidden" name="quantity" class="quantity-input" value="1">
                <div class="form-row align-items-center mb-2">
                  <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="small">数量:</span>
                      <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-quantity-decrease" data-max="{{ $goods->goods_stock }}" disabled>
                          <i class="fas fa-minus"></i>
                        </button>
                        <span class="mx-2 quantity-display">1</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-quantity-increase" data-max="{{ $goods->goods_stock }}">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-success btn-block btn-sm">
                  <i class="fas fa-shopping-cart"></i> カートに追加
                </button>
              </form>
            @else
              <button class="btn btn-secondary btn-block mt-auto mb-2" disabled>
                在庫切れ
              </button>
            @endif
            
            <a href="{{ route('goods_detail', ['un_id' => $goods->un_id]) }}" class="btn btn-primary">詳細を見る</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    {{ $goods_list->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
</div>
  
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // 数量増加ボタン
  document.querySelectorAll('.btn-quantity-increase').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      const quantityInput = form.querySelector('.quantity-input');
      const quantityDisplay = form.querySelector('.quantity-display');
      const decreaseBtn = form.querySelector('.btn-quantity-decrease');
      const maxStock = parseInt(this.getAttribute('data-max'));
      
      let currentQuantity = parseInt(quantityInput.value);
      
      if (currentQuantity < maxStock) {
        currentQuantity++;
        quantityInput.value = currentQuantity;
        quantityDisplay.textContent = currentQuantity;
        
        // 減少ボタンを有効化
        decreaseBtn.disabled = false;
        
        // 最大値に達したら増加ボタンを無効化
        if (currentQuantity >= maxStock) {
          this.disabled = true;
        }
      }
    });
  });
  
  // 数量減少ボタン
  document.querySelectorAll('.btn-quantity-decrease').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      const quantityInput = form.querySelector('.quantity-input');
      const quantityDisplay = form.querySelector('.quantity-display');
      const increaseBtn = form.querySelector('.btn-quantity-increase');
      
      let currentQuantity = parseInt(quantityInput.value);
      
      if (currentQuantity > 1) {
        currentQuantity--;
        quantityInput.value = currentQuantity;
        quantityDisplay.textContent = currentQuantity;
        
        // 増加ボタンを有効化
        increaseBtn.disabled = false;
        
        // 最小値に達したら減少ボタンを無効化
        if (currentQuantity <= 1) {
          this.disabled = true;
        }
      }
    });
  });
});

// お気に入りボタンの処理（商品一覧ページ）
$(document).ready(function() {
  $('.favorite-btn-list').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var btn = $(this);
    var goodsId = btn.data('goods-id');
    var isFavorited = btn.data('favorited') === 'true';
    var url = isFavorited ? '{{ route("favorite_remove") }}' : '{{ route("favorite_add") }}';
    
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        goods_id: goodsId
      },
      success: function(response) {
        if (response.success) {
          // ボタンの状態を切り替え
          if (isFavorited) {
            btn.data('favorited', 'false');
            btn.find('i').removeClass('fas').addClass('far');
          } else {
            btn.data('favorited', 'true');
            btn.find('i').removeClass('far').addClass('fas');
          }
        } else {
          alert(response.message);
        }
      },
      error: function() {
        alert('エラーが発生しました。');
      }
    });
  });
});
</script>
@endsection
