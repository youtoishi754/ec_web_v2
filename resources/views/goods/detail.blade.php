@extends('layouts.parents')
@section('title', '商品詳細')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item"><a href="{{ route('goods_list') }}">商品一覧</a></li>
      <li class="breadcrumb-item active" aria-current="page">商品詳細</li>
    </ol>
  </nav>

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

  {{-- 見出し --}}
  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">商品詳細</h3>

  <div class="row mt-4">
    <div class="col-md-6">
      {{-- 商品画像 --}}
      <img class="img-fluid" src="{{ asset('public/product-image/dummy.png') }}" alt="{{ $goods_data->goods_name }}">
    </div>

    <div class="col-md-6">
      {{-- 商品情報 --}}
      <h2 class="mb-3">{{ $goods_data->goods_name }}</h2>
      
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="text-danger mb-3">¥{{ number_format($goods_data->goods_price) }}</h4>
          
          <table class="table table-sm">
            <tr>
              <th style="width: 30%;">商品番号</th>
              <td>{{ $goods_data->goods_number }}</td>
            </tr>
            <tr>
              <th>在庫数</th>
              <td>
                @if($goods_data->goods_stock > 0)
                  <span class="text-success">{{ $goods_data->goods_stock }}個</span>
                @else
                  <span class="text-danger">在庫切れ</span>
                @endif
              </td>
            </tr>
            @if($goods_data->intro_txt)
            <tr>
              <th>商品説明</th>
              <td>{!! $goods_data->intro_txt !!}</td>
            </tr>
            @endif
            <tr>
              <th>状態</th>
              <td>@if( $goods_data->disp_flg == 0) 表示 @else 非表示 @endif</td>
            </tr>
          </table>

          {{-- カート追加フォーム --}}
          @if($goods_data->goods_stock > 0)
            <form action="{{ route('cart_add') }}" method="POST">
              @csrf
              <input type="hidden" name="goods_id" value="{{ $goods_data->id }}">
              
              <div class="form-group">
                <label for="quantity">数量</label>
                <div class="input-group" style="max-width: 150px;">
                  <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $goods_data->goods_stock }}" required>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-lg btn-block">
                <i class="fas fa-shopping-cart"></i> カートに追加
              </button>
            </form>
          @else
            <button class="btn btn-secondary btn-lg btn-block" disabled>
              在庫切れ
            </button>
          @endif
        </div>
      </div>

      <div class="mt-3">
        <a href="{{ route('goods_list') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left"></i> 商品一覧に戻る
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
