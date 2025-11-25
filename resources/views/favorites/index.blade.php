@extends('layouts.parents')
@section('title', 'お気に入り')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
      <li class="breadcrumb-item active" aria-current="page">お気に入り</li>
    </ol>
  </nav>

  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">お気に入り商品</h3>

  @if($favorites->isEmpty())
    <div class="alert alert-info mt-4">
      <i class="fas fa-info-circle"></i> お気に入り登録された商品がありません。
    </div>
    <div class="text-center mt-4">
      <a href="{{ route('goods_list') }}" class="btn btn-primary">
        <i class="fas fa-shopping-bag"></i> 商品一覧へ
      </a>
    </div>
  @else
    <div class="row mt-4">
      @foreach($favorites as $goods)
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card h-100">
            <img class="card-img-top" src="{{ asset('public/product-image/dummy.png') }}" alt="{{ $goods->goods_name }}">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $goods->goods_name }}</h5>
              <p class="card-text text-muted small">{{ Str::limit($goods->intro_txt, 50) }}</p>
              <div class="mt-auto">
                <h4 class="text-danger mb-3">¥{{ number_format($goods->goods_price) }}</h4>
                <div class="d-flex justify-content-between">
                  <a href="{{ route('goods_detail') }}?un_id={{ $goods->un_id }}" class="btn btn-primary flex-fill mr-2">
                    <i class="fas fa-info-circle"></i> 詳細
                  </a>
                  <button class="btn btn-outline-danger favorite-remove-btn" data-goods-id="{{ $goods->id }}">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>

<script>
// お気に入り削除ボタンの処理
$(document).ready(function() {
  $('.favorite-remove-btn').on('click', function() {
    var btn = $(this);
    var goodsId = btn.data('goods-id');
    
    if (!confirm('お気に入りから削除しますか?')) {
      return;
    }
    
    $.ajax({
      url: '{{ route("favorite_remove") }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        goods_id: goodsId
      },
      success: function(response) {
        if (response.success) {
          // カードを削除
          btn.closest('.col-md-4').fadeOut(function() {
            $(this).remove();
            
            // 全て削除された場合はページをリロード
            if ($('.col-md-4').length === 0) {
              location.reload();
            }
          });
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
