<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 py-16 text-center">

        {{-- Success Icon --}}
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
            <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mt-6">Payment Successful!</h1>
        <p class="text-gray-500 mt-2">Thank you for your order.</p>

        {{-- Order Details --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 mt-8 text-left">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 text-sm">Order Number</span>
                <span class="font-bold text-gray-800">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 text-sm">Status</span>
                <span class="bg-green-100 text-green-600 text-xs font-medium px-3 py-1 rounded-full">
                    Paid
                </span>
            </div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 text-sm">Total Amount</span>
                <span class="font-bold text-gray-800">
                    ${{ number_format($order->total_amount, 2) }}
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 text-sm">Date</span>
                <span class="text-gray-800 text-sm">
                    {{ $order->created_at->format('M d, Y') }}
                </span>
            </div>
        </div>

        <p class="text-sm text-gray-400 mt-6">
            A confirmation email with your invoice will be sent shortly.
        </p>

        <a href="{{ route('products.index') }}"
           class="mt-8 inline-block bg-gray-900 text-white px-8 py-3 rounded-xl hover:bg-gray-700 transition">
            Continue Shopping
        </a>
    </div>
</x-app-layout>
