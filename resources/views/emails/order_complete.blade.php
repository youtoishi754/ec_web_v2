<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Hiragino Kaku Gothic Pro', 'ヒラギノ角ゴ Pro', 'Yu Gothic', 'メイリオ', Meiryo, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .order-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .alert {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>ご注文ありがとうございます</h2>
    </div>

    <p>{{ $order->user->name }} 様</p>

    <p>このたびはご注文いただき、誠にありがとうございます。<br>
    以下の内容でご注文を承りました。</p>

    <div class="order-info">
        <p><strong>注文番号:</strong> {{ $order->order_number }}</p>
        <p><strong>注文日時:</strong> {{ $order->ordered_at->format('Y年m月d日 H:i') }}</p>
        <p><strong>ステータス:</strong> {{ $order->status->name }}</p>
    </div>

    <h3>ご注文内容</h3>
    <table>
        <thead>
            <tr>
                <th>商品名</th>
                <th style="text-align: right;">単価</th>
                <th style="text-align: center;">数量</th>
                <th style="text-align: right;">小計</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->goods_name }}</td>
                <td style="text-align: right;">¥{{ number_format($detail->price) }}</td>
                <td style="text-align: center;">{{ $detail->quantity }}</td>
                <td style="text-align: right;">¥{{ number_format($detail->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>商品小計:</strong></td>
                <td style="text-align: right;">¥{{ number_format($order->total_price) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>送料:</strong></td>
                <td style="text-align: right;">¥{{ number_format($order->shipping_fee) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;"><strong>合計金額:</strong></td>
                <td style="text-align: right;"><strong>¥{{ number_format($order->calculateGrandTotal()) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <h3>配送先情報</h3>
    <div class="order-info">
        <p><strong>宛名:</strong> {{ $order->shipping_name }}</p>
        <p><strong>住所:</strong> {{ $order->shipping_address }}</p>
    </div>

    <h3>お支払い方法</h3>
    <div class="order-info">
        <p>{{ $order->paymentMethod->name }}</p>
        
        @if($order->payment_id == 1)
            <p style="color: #28a745;">✓ クレジットカード決済が完了しました。</p>
        @elseif($order->payment_id == 2)
            <p>商品受取時に配達員にお支払いください。</p>
        @elseif($order->payment_id == 3)
            <div class="alert">
                <p><strong>【重要】銀行振込のご案内</strong></p>
                <p>以下の口座にお振込みください。入金確認後、商品を発送いたします。</p>
                <p>
                    <strong>振込先:</strong><br>
                    ○○銀行 ○○支店<br>
                    普通 1234567<br>
                    名義：カ）イーシーショップ<br>
                    <strong>振込金額:</strong> ¥{{ number_format($order->calculateGrandTotal()) }}
                </p>
            </div>
        @endif
    </div>

    <p>商品の発送が完了しましたら、改めてご連絡いたします。</p>

    <div class="footer">
        <p>
            ※このメールは自動送信されています。<br>
            ※ご不明な点がございましたら、下記までお問い合わせください。
        </p>
        <p>
            <strong>お問い合わせ先:</strong><br>
            メール: support@example.com<br>
            電話: 03-1234-5678（平日 10:00-18:00）
        </p>
        <p>
            今後とも当店をよろしくお願いいたします。
        </p>
    </div>
</body>
</html>
