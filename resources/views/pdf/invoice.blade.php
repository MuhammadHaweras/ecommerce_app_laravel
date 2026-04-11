<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 24px; color: #111; }
        .header p { color: #888; font-size: 12px; }
        .section { margin-bottom: 20px; }
        .section h3 { border-bottom: 1px solid #eee; padding-bottom: 6px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f4f4f4; text-align: left; padding: 8px; font-size: 12px; }
        td { padding: 8px; border-bottom: 1px solid #f0f0f0; font-size: 12px; }
        .total-row td { font-weight: bold; font-size: 14px; border-top: 2px solid #333; }
        .badge { background: #d1fae5; color: #065f46; padding: 3px 10px; border-radius: 20px; font-size: 11px; }
        .footer { text-align: center; margin-top: 40px; color: #aaa; font-size: 11px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>🛒 TechStore</h1>
        <p>Order Invoice</p>
    </div>

    {{-- Order Info --}}
    <div class="section">
        <h3>Order Details</h3>
        <table>
            <tr>
                <td><strong>Order Number</strong></td>
                <td>{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td><strong>Order Date</strong></td>
                <td>{{ $order->created_at->format('F d, Y \a\t g:i A') }}</td>
            </tr>
            <tr>
                <td><strong>Payment Status</strong></td>
                <td><span class="badge">Paid</span></td>
            </tr>
            <tr>
                <td><strong>Payment ID</strong></td>
                <td>{{ $order->stripe_payment_id }}</td>
            </tr>
        </table>
    </div>

    {{-- Customer Info --}}
    <div class="section">
        <h3>Customer Details</h3>
        <table>
            <tr>
                <td><strong>Name</strong></td>
                <td>{{ $order->user->name }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $order->user->email }}</td>
            </tr>
        </table>
    </div>

    {{-- Order Items --}}
    <div class="section">
        <h3>Items Ordered</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total Amount</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for shopping with TechStore!</p>
        <p>This is an auto-generated invoice. Please keep it for your records.</p>
    </div>

</body>
</html>