<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function checkout(){
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();

        if($cartItems->isEmpty()){
            return redirect()->route('cart.index')->with('error','Cart is Empty');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = $cartItems->map(fn($item) => [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $item->product->name,
                ],
                'unit_amount' => (int)($item->product->price * 100),
            ],
            'quantity' => $item->quantity,
        ])->toArray();

        // Stripe Checkout Session

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index') 
        ]);

        return redirect($session->url);
    }

    public function success(Request $request){
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::retrieve($request->session_id);

        if ($session->payment_status !== 'paid'){
            return redirect()->route('cart.index')->with('error','Payment not completed');
        }

        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $orderNumber = 'ORD-' . date('Y') . '-' . str_pad(
            Order::count() + 1, 5, '0', STR_PAD_LEFT
        );

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'total_amount' => $total,
            'status' => 'paid',
            'stripe_payment_id' => $session->payment_intent,
        ]);

        foreach ($cartItems as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
            ]);

            $item->product->decrement('stock', $item->quantity);
        }

        CartItem::where('user_id', auth()->id())->delete();

        return view('checkout.success', compact('order'));
    }

    public function cancel(){
        return redirect()->route('cart.index')->with('error', 'Payment cancelled');
    }
}
