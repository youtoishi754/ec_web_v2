@extends('layouts.parents')

@section('title', '注文履歴')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header mt-4 mb-4">注文履歴</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($orders->isEmpty())
                <div class="alert alert-info">
                    注文履歴がありません。
                </div>
                <a href="{{ route('goods_list') }}" class="btn btn-primary">商品を探す</a>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>注文番号</th>
                                <th>注文日時</th>
                                <th>合計金額</th>
                                <th>ステータス</th>
                                <th>支払方法</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->ordered_at->format('Y年m月d日 H:i') }}</td>
                                <td>¥{{ number_format($order->calculateGrandTotal()) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status_id == 1) badge-warning
                                        @elseif($order->status_id == 2) badge-info
                                        @elseif($order->status_id == 3) badge-primary
                                        @elseif($order->status_id == 4) badge-success
                                        @else badge-secondary
                                        @endif
                                    ">
                                        {{ $order->status->name }}
                                    </span>
                                </td>
                                <td>{{ $order->paymentMethod->name }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> 詳細
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- ページネーション -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
