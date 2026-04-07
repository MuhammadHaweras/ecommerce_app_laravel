<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart.index', compact('cartItems','total'));
    }

    // Add item to cart

    public function add(Request $request, Product $product){
        $cartItem = CartItem::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        if ($cartItem){
            $cartItem->increment('quantity');
        }else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success','Product added to cart');
    }

    public function update(Request $request, CartItem $cartItem){
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem->update(['quantity' => $request->quantity ]);
        return redirect()->back()->with('success','Cart Updated');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
