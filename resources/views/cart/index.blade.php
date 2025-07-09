<x-layout>
    <h1>Your Cart</h1>

    @if (auth()->check())
        @foreach ($cartItems as $item)
            <div class="cartitem">
                {{ $item->product->productname }} - ₱{{ $item->product->price }} x {{ $item->quantity }}
            </div>
        @endforeach
    @else
        @foreach ($cartItems as $id => $item)
            <div class="cartitem">
                {{ $item['productname'] }} - ₱{{ $item['price'] }} x {{ $item['quantity'] }}
            </div>
        @endforeach
    @endif

    <br>
    <button id="checkout-btn" class="px-4 py-2 bg-green-600 text-white rounded">Checkout</button>

</x-layout>

