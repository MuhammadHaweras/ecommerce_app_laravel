<x-app-layout>
    {{-- Hero Section --}}
    <div class="bg-gray-900 text-white py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to TechStore 🛒</h1>
            <p class="text-gray-400 text-lg mb-8">
                Latest laptops, tablets, mobiles and smart watches at the best prices.
            </p>
            <a href="{{ route('products.index') }}"
               class="bg-white text-gray-900 px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
                Shop Now →
            </a>
        </div>
    </div>

    {{-- Categories Section --}}
    <div class="max-w-6xl mx-auto px-4 py-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach(\App\Models\Category::all() as $category)
                <a href="{{ route('products.index') }}?category={{ $category->id }}"
                   class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition">
                    <p class="font-semibold text-gray-800">{{ $category->name }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $category->products()->where('is_active', true)->count() }} products
                    </p>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Featured Products --}}
    <div class="max-w-6xl mx-auto px-4 pb-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(\App\Models\Product::where('is_active', true)->latest()->take(6)->get() as $product)
                <a href="{{ route('products.show', $product->slug) }}"
                   class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition">
                    <div class="bg-gray-50 h-48 flex items-center justify-center p-4">
                        <img src="{{ Storage::url($product->image) }}"
                             alt="{{ $product->name }}"
                             class="h-full object-contain"/>
                    </div>
                    <div class="p-4">
                        <span class="text-xs text-gray-400">{{ $product->category->name }}</span>
                        <h3 class="font-semibold text-gray-800 mt-1">{{ $product->name }}</h3>
                        <p class="font-bold text-gray-900 mt-2">${{ number_format($product->price, 2) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}"
               class="border border-gray-300 text-gray-700 px-8 py-3 rounded-xl hover:bg-gray-50 transition">
                View All Products →
            </a>
        </div>
    </div>
</x-app-layout>