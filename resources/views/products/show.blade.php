<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <img src="{{ Storage::url($product->image) }}"
                 alt="{{ $product->name }}"
                 class="rounded-xl object-cover"/>
            <div>
                <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                <h1 class="text-2xl font-bold text-gray-800 mt-1">{{ $product->name }}</h1>
                <p class="text-2xl font-bold text-gray-900 mt-4">${{ $product->price }}</p>
                <p class="text-gray-600 mt-4">{{ $product->description }}</p>
                <p class="mt-4 text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                    {{ $product->stock > 0 ? 'In Stock ('.$product->stock.' available)' : 'Out of Stock' }}
                </p>
                <form method="POST" action="{{ route('cart.add', $product) }}">
                    @csrf
                    <button type="submit" class="mt-6 w-full bg-gray-800 text-white py-3 rounded-xl hover:bg-gray-700">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
