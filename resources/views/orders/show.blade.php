@extends('layouts.parents')

@section('title', '注文詳細')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header mt-4 mb-4">注文詳細</h1>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">注文情報</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>注文番号:</strong> {{ $order->order_number }}</p>
                            <p><strong>注文日時:</strong> {{ $order->ordered_at->format('Y年m月d日 H:i') }}</p>
                            <p>
                                <strong>ステータス:</strong> 
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
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>支払方法:</strong> {{ $order->paymentMethod->name }}</p>
                            @if($order->payment_id == 3)
                                <div class="alert alert-warning">
                                    <strong>銀行振込の場合</strong><br>
                                    以下の口座にお振込みください：<br>
                                    ○○銀行 ○○支店<br>
                                    普通 1234567<br>
                                    名義：カ）イーシーショップ
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">配送先情報</h5>
                </div>
                <div class="card-body">
                    <p><strong>宛名:</strong> {{ $order->shipping_name }}</p>
                    <p><strong>住所:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">注文商品</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>商品名</th>
                                    <th>単価</th>
                                    <th>数量</th>
                                    <th class="text-right">小計</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        {{ $detail->goods_name }}
                                        @if($detail->goods)
                                            <a href="{{ route('goods_detail', ['id' => $detail->goods_id]) }}" class="btn btn-sm btn-link">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>¥{{ number_format($detail->price) }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td class="text-right">¥{{ number_format($detail->subtotal) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>小計:</strong></td>
                                    <td class="text-right">¥{{ number_format($order->total_price) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>送料:</strong></td>
                                    <td class="text-right">¥{{ number_format($order->shipping_fee) }}</td>
                                </tr>
                                <tr class="table-active">
                                    <td colspan="3" class="text-right"><strong>合計:</strong></td>
                                    <td class="text-right"><strong>¥{{ number_format($order->calculateGrandTotal()) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> 注文履歴に戻る
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
