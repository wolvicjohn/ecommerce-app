<x-layout>
    <h1 class="text-xl font-bold mb-4">Order History</h1>
    @auth
    @if($orders->isEmpty())
        <p>No orders yet.</p>
    @else
        @foreach ($orders as $order)
            <div class="mb-2 border p-2 rounded">
                {{ $order->product->productname ?? 'Deleted Product' }} × {{ $order->quantity }}
                <br>
                <small>Ordered on {{ $order->created_at->format('F j, Y h:i A') }}</small>
            </div>
        @endforeach
    @endif
    @endauth
</x-layout>
