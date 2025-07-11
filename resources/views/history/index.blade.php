<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-6">🧾 Order History</h1>

        @auth
            @if($orders->isEmpty())
                <p class="text-gray-400 text-lg">You haven’t placed any orders yet.</p>
            @else
                <div class="relative border-l border-gray-700 pl-6">
                    @foreach ($orders as $order)
                        <div class="mb-8 relative">
                            <!-- Dot on timeline -->
                            <span class="absolute -left-3 top-2 w-4 h-4 bg-blue-500 border-2 border-white rounded-full shadow-md"></span>

                            <!-- Order Card -->
                            <div class="bg-gray-800 border border-gray-700 rounded-lg p-4 shadow-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h2 class="text-lg font-semibold text-white">
                                            {{ $order->product->productname ?? '🗑 Deleted Product' }}
                                        </h2>
                                        <p class="text-sm text-gray-400">Quantity: {{ $order->quantity }}</p>
                                    </div>
                                    <span class="text-sm text-gray-400 whitespace-nowrap">
                                        {{ $order->created_at->format('M d, Y • h:i A') }}
                                    </span>
                                </div>

                                @if($order->product)
                                    <div class="mt-2 text-sm text-gray-300">
                                        Price: ₱{{ number_format($order->product->price * $order->quantity, 2) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endauth
    </div>
</x-layout>
