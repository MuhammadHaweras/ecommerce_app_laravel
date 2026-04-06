<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $categories = Category::all();
        $products = Product::with('category')
        ->where('is_active', true)
        ->when($request->search, fn($q)=> $q->where('name', 'like', "%{$request->search}%"))
        ->when($request->category, fn($q) => $q->where('category_id', $request->category) )
        ->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
        ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
        ->when($request->sort == 'price_low', fn($q) => $q->orderBy('price', 'asc'))
        ->when($request->sort == 'price_high', fn($q) => $q->orderBy('price', 'desc'))
        ->paginate(12);

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product){
        return view('products.show', compact('product'));
    }
}
