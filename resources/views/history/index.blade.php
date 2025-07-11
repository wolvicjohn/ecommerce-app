<x-layout>
    <h1 class="text-2xl font-bold text-white mb-6">🧾 Order History</h1>

    @auth
        @if($orders->isEmpty())
            <p class="text-gray-400">No orders yet.</p>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="bg-gray-800 border border-gray-700 rounded-lg p-4 shadow-md text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-lg font-semibold">
                                    {{ $order->product->productname ?? '🗑 Deleted Product' }}
                                </p>
                                <p class="text-sm text-gray-400">Quantity: {{ $order->quantity }}</p>
                            </div>
                            <span class="text-sm text-gray-500">
                                {{ $order->created_at->format('F j, Y • h:i A') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endauth
</x-layout>

