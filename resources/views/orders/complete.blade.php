@extends('layouts.parents')

@section('title', '注文完了')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mt-5 mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                <h1 class="mt-3">ご注文ありがとうございます!</h1>
                <p class="lead">注文が正常に完了しました。</p>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">注文情報</h5>
                </div>
                <div class="card-body">
                    <p><strong>注文番号:</strong> {{ $order->order_number }}</p>
                    <p><strong>注文日時:</strong> {{ $order->ordered_at->format('Y年m月d日 H:i') }}</p>
                    <p><strong>合計金額:</strong> ¥{{ number_format($order->calculateGrandTotal()) }}</p>
                    <p><strong>支払方法:</strong> {{ $order->paymentMethod->name }}</p>
                    
                    @if($order->payment_id == 1)
                        <div class="alert alert-success">
                            <i class="fas fa-check"></i> クレジットカード決済が完了しました。
                        </div>
                    @elseif($order->payment_id == 2)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 商品受取時に配達員にお支払いください。
                        </div>
                    @elseif($order->payment_id == 3)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <strong>銀行振込のご案内</strong><br>
                            以下の口座にお振込みください。入金確認後、商品を発送いたします。<br><br>
                            ○○銀行 ○○支店<br>
                            普通 1234567<br>
                            名義：カ）イーシーショップ<br>
                            振込金額：¥{{ number_format($order->calculateGrandTotal()) }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">配送先</h5>
                </div>
                <div class="card-body">
                    <p><strong>宛名:</strong> {{ $order->shipping_name }}</p>
                    <p><strong>住所:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-envelope"></i> 
                ご登録のメールアドレスに注文確認メールをお送りしました。
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-2">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-file-alt"></i> 注文詳細を見る
                    </a>
                </div>
                <div class="col-md-6 mb-2">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-history"></i> 注文履歴を見る
                    </a>
                </div>
            </div>
            
            <div class="text-center mb-5">
                <a href="{{ route('goods_list') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> 引き続きお買い物をする
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
