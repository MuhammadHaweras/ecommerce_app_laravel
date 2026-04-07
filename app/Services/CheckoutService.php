<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createCheckoutSession(): StripeSession
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return null;
        }

        $lineItems = $this->buildLineItems($cartItems);

        return StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index'),
        ]);
    }

    public function handleSuccessfulPayment(string $sessionId): ?Order
    {
        $session = StripeSession::retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return null;
        }

        return $this->createOrder($session->payment_intent);
    }

    public function getCartItems()
    {
        return CartItem::with('product')->where('user_id', auth()->id())->get();
    }

    protected function buildLineItems($cartItems): array
    {
        return $cartItems->map(fn($item) => [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $item->product->name,
                ],
                'unit_amount' => (int)($item->product->price * 100),
            ],
            'quantity' => $item->quantity,
        ])->toArray();
    }

    protected function createOrder(string $paymentIntentId): Order
    {
        $cartItems = $this->getCartItems();
        $total = $this->calculateTotal($cartItems);

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $this->generateOrderNumber(),
            'total_amount' => $total,
            'status' => 'paid',
            'stripe_payment_id' => $paymentIntentId,
        ]);

        $this->createOrderItems($order, $cartItems);
        $this->clearCart();

        return $order;
    }

    protected function calculateTotal($cartItems): float
    {
        return $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
    }

    protected function generateOrderNumber(): string
    {
        return 'ORD-' . date('Y') . '-' . str_pad(
            Order::count() + 1, 5, '0', STR_PAD_LEFT
        );
    }

    protected function createOrderItems(Order $order, $cartItems): void
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
            ]);

            $item->product->decrement('stock', $item->quantity);
        }
    }

    protected function clearCart(): void
    {
        CartItem::where('user_id', auth()->id())->delete();
    }
}