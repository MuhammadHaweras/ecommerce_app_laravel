<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct(protected CheckoutService $checkoutService) {}

    public function checkout()
    {
        $session = $this->checkoutService->createCheckoutSession();

        if (!$session) {
            return redirect()->route('cart.index')->with('error', 'Cart is Empty');
        }

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $order = $this->checkoutService->handleSuccessfulPayment($request->session_id);

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Payment not completed');
        }

        //  Send Confirmation Mail

        Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
        return view('checkout.success', compact('order'));
    }

    public function cancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment cancelled');
    }
}