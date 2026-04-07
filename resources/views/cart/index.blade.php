<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Your Cart</h1>

        @if($cartItems->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <p class="text-lg">Your cart is empty.</p>
                <a href="{{ route('products.index') }}"
                   class="mt-4 inline-block text-blue-500 hover:underline">
                   Continue Shopping
                </a>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach($cartItems as $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-6">

                        {{-- Product Image --}}
                        <img src="{{ Storage::url($item->product->image) }}"
                             alt="{{ $item->product->name }}"
                             class="h-20 w-20 object-contain rounded-lg bg-gray-50"/>

                        {{-- Product Info --}}
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-400">{{ $item->product->category->name }}</p>
                            <p class="text-gray-900 font-bold mt-1">
                                ${{ number_format($item->product->price, 2) }}
                            </p>
                        </div>

                        {{-- Quantity Update --}}
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity"
                                   value="{{ $item->quantity }}"
                                   min="1"
                                   class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-center text-sm"/>
                            <button type="submit"
                                class="text-sm text-gray-500 hover:text-gray-800 underline">
                                Update
                            </button>
                        </form>

                        {{-- Subtotal --}}
                        <div class="text-right w-24">
                            <p class="font-bold text-gray-800">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </p>
                            <p class="text-xs text-gray-400">subtotal</p>
                        </div>

                        {{-- Remove --}}
                        <form method="POST" action="{{ route('cart.remove', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 text-sm">
                                ✕ Remove
                            </button>
                        </form>
                        <a href="{{ route('products.index') }}"> Browse Products...</a>
                    </div>
                @endforeach
            </div>

            {{-- Cart Total --}}
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Amount</p>
                    <p class="text-3xl font-bold text-gray-900">${{ number_format($total, 2) }}</p>
                </div>
                <a href="#"
                   class="bg-gray-900 text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-700 transition">
                    Proceed to Checkout
                </a>
            </div>
        @endif
    </div>
</x-app-layout>