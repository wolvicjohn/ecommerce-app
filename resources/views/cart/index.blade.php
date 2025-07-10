<x-layout>
    <h1>Your Cart</h1>

    @if (auth()->check())
        @foreach ($cartItems as $item)
            <div class="cart-form">
                <div class="cartitem">
                    {{ $item->product->productname }} - ₱{{ $item->product->price }} x {{ $item->quantity }}
                </div>
            </div>
        @endforeach
    @else
        @foreach ($cartItems as $id => $item)
            <div class="cart-form">
                <div class="cartitem">
                    {{ $item['productname'] }} - ₱{{ $item['price'] }} x {{ $item['quantity'] }}
                </div>
            </div>
        @endforeach
    @endif

    <br>
    @if(count($cartItems) > 0)
        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <button id="checkout-btn" type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded">
                Place Order
            </button>

        </form>
    @endif

</x-layout>

