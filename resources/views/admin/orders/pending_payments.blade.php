<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>決済未完了注文一覧 - 管理画面</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .main-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header-section h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header-section p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
            padding: 15px 10px;
        }
        .table tbody td {
            vertical-align: middle;
            padding: 15px 10px;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 20px;
        }
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            padding: 8px 16px;
            font-weight: 500;
            transition: transform 0.2s;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
        }
        .btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
            padding: 6px 12px;
            font-size: 13px;
        }
        .btn-outline-primary:hover {
            background-color: #667eea;
            border-color: #667eea;
        }
        .alert {
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
        }
        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
        }
        .stats-label {
            color: #6c757d;
            font-size: 14px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        .text-completed {
            color: #28a745;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header-section">
            <h1><i class="fas fa-file-invoice-dollar"></i> 決済未完了注文一覧</h1>
            <p>入金確認が必要な注文を管理します</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if(!$orders->isEmpty())
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">{{ $orders->total() }}</div>
                        <div class="stats-label">未完了注文数</div>
                    </div>
                </div>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="table-container">
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <h3>決済未完了の注文はありません</h3>
                    <p class="text-muted">すべての注文の決済が完了しています。</p>
                    <a href="{{ route('mypage') }}" class="btn btn-secondary mt-3">
                        <i class="fas fa-arrow-left"></i> マイページに戻る
                    </a>
                </div>
            </div>
        @else
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="140">注文番号</th>
                                <th>ユーザー情報</th>
                                <th width="140">注文日時</th>
                                <th width="110" class="text-right">合計金額</th>
                                <th width="110">支払方法</th>
                                <th width="110">決済状態</th>
                                <th width="110">注文状態</th>
                                <th width="200" class="text-center">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_number }}</strong>
                                </td>
                                <td>
                                    <div><strong>{{ $order->user->name ?? 'N/A' }}</strong></div>
                                    <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    <small>{{ $order->ordered_at->format('Y/m/d') }}</small><br>
                                    <small class="text-muted">{{ $order->ordered_at->format('H:i') }}</small>
                                </td>
                                <td class="text-right">
                                    <strong>¥{{ number_format($order->calculateGrandTotal()) }}</strong>
                                </td>
                                <td>
                                    <small>{{ $order->paymentMethod->name ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @if($order->payment_status == 0)
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> 未決済
                                        </span>
                                    @elseif($order->payment_status == 1)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> 決済完了
                                        </span>
                                    @elseif($order->payment_status == 2)
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times"></i> 決済失敗
                                        </span>
                                    @elseif($order->payment_status == 3)
                                        <span class="badge badge-info">
                                            <i class="fas fa-undo"></i> 返金済み
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">不明</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($order->status_id == 9) badge-warning
                                        @elseif($order->status_id == 1) badge-info
                                        @elseif($order->status_id == 2) badge-primary
                                        @elseif($order->status_id == 3) badge-success
                                        @else badge-secondary
                                        @endif
                                    ">
                                        {{ $order->status->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if(!$order->isPaid())
                                        <form action="{{ route('admin.orders.mark_as_paid', $order->id) }}" method="POST" 
                                              onsubmit="return confirm('この注文を入金確認済みにしますか？\n注文番号: {{ $order->order_number }}');" 
                                              style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> 入金確認
                                            </button>
                                        </form>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> 詳細
                                        </a>
                                    @else
                                        <span class="text-completed">
                                            <i class="fas fa-check-circle"></i> 完了
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('mypage') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> マイページに戻る
                </a>
            </div>
        @endif
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
