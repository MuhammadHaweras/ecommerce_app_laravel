<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">My Orders</h1>

        @if($orders->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <p>You have no orders yet.</p>
                <a href="{{ route('products.index') }}"
                   class="mt-4 inline-block text-blue-500 hover:underline">
                   Start Shopping
                </a>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach($orders as $order)
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        {{-- Order Header --}}
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="font-bold text-gray-800">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <p class="font-bold text-gray-800 mt-1">
                                    ${{ number_format($order->total_amount, 2) }}
                                </p>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="border-t border-gray-100 pt-4 flex flex-col gap-2">
                            @foreach($order->orderItems as $item)
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                                    <span>${{ number_format($item->unit_price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
