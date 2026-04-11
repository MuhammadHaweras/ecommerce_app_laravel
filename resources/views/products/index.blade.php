<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- filters form --}}
        <form method="get" action="{{ route('products.index') }}" class="mb-8 grid grid-cols-1 md:grid-col-5 gap-4">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search Products..."
            class="border rounded-lg px-4 py-2 col-span-2" />

            <select name="category" class="border rounded-lg px-4 py-2">
                <option value=""> All Categories </option>
                @foreach ($categories as $category )
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort" class="border rounded-lg px-4 py-2">
                <option value=""> Sort By </option>
                <option value="price_low {{ request('sort') == 'price_low' ? 'selected' : '' }}">
                    Price: Low to High
                </option>
                <option value="price_high {{ request('sort') == 'price_high' ? 'selected' : '' }}">
                    Price: High to Low
                </option>
            </select>
            <button type="submit" class="bg-gray-800 text-white rounded-lg px-4 py-2 hover:bg-gray-700">
                Filter
            </button>
        </form>

        {{-- price range --}}

        <form method="GET" action="{{ route('products.index') }}"
              class="mb-8 flex gap-4 items-center mt-2">
            <input type="hidden" name="search" value="{{ request('search') }}"/>
            <input type="hidden" name="category" value="{{ request('category') }}"/>
            <input type="hidden" name="sort" value="{{ request('sort') }}"/>
            <input type="number" name="min_price" value="{{ request('min_price') }}"
                placeholder="Min Price" class="border rounded-lg px-4 py-2 w-36"/>
            <input type="number" name="max_price" value="{{ request('max_price') }}"
                placeholder="Max Price" class="border rounded-lg px-4 py-2 w-36"/>
            <button type="submit"
                class="bg-gray-800 text-white rounded-lg px-4 py-2 hover:bg-gray-700">
                Apply
            </button>
            <a href="{{ route('products.index') }}"
                class="text-gray-500 hover:underline text-sm">
                Clear Filters
            </a>
        </form>

        {{-- products grid --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->slug) }}"
                class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
            
                    <div class="overflow-hidden h-52 bg-gray-100">
                        <img src="{{ Storage::url($product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-contain p-4 hover:scale-105 transition duration-300"/>
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <span class="text-xs text-gray-400 uppercase tracking-wide">
                            {{ $product->category->name }}
                        </span>
                        <h3 class="font-semibold text-gray-800 mt-1 text-sm leading-snug">
                            {{ $product->name }}
                        </h3>
                        <p class="text-lg font-bold text-gray-900 mt-2">
                            ${{ number_format($product->price, 2) }}
                        </p>
                        <p class="text-xs mt-1 {{ $product->stock > 0 ? 'text-green-500' : 'text-red-400' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </p>
                    </div>

                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500 py-12">No products found.</p>
            @endforelse
        </div>

        {{-- pagination --}}

        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
