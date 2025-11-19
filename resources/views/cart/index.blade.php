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
    <div class="table-responsive mt-4">
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
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
          <tr>
            <td>{{ $item['goods_number'] }}</td>
            <td>{{ $item['goods_name'] }}</td>
            <td>¥{{ number_format($item['goods_price']) }}</td>
            <td>{{ $item['quantity'] }}個</td>
            <td>¥{{ number_format($item['goods_price'] * $item['quantity']) }}</td>
            <td>
              <form action="{{ route('cart_remove') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="goods_id" value="{{ $item['goods_id'] }}">
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('この商品をカートから削除しますか？')">削除</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" class="text-right">合計</th>
            <th colspan="2">¥{{ number_format($total) }}</th>
          </tr>
        </tfoot>
      </table>
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
@endsection
