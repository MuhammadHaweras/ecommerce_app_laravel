<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; padding: 30px; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h1 { color: #111; }
        .order-box { background: #f4f4f4; border-radius: 8px; padding: 16px; margin: 20px 0; }
        .order-box p { margin: 6px 0; font-size: 14px; }
        .items-table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        .items-table th { background: #eee; padding: 10px; text-align: left; font-size: 13px; }
        .items-table td { padding: 10px; border-bottom: 1px solid #ddd; font-size: 13px; }
        .items-table .total-row td { font-weight: bold; border-top: 2px solid #333; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #aaa; }
        .btn { display: inline-block; background: #111; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 TechStore</h1>
            <p>Thank you for your order!</p>
        </div>

        <p>Hi <strong>{{ $order->user->name }}</strong>,</p>
        <p>Your payment was successful. Here is a summary of your order:</p>

        <div class="order-box">
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
            <p><strong>Status:</strong> Paid ✅</p>
        </div>

        <h3 style="margin: 20px 0 10px; font-size: 16px;">Order Items</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
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

        <p>We have attached your invoice to this email as a PDF.</p>

        <div class="footer">
            <p>TechStore — Your trusted electronics store</p>
        </div>
    </div>
</body>
</html>