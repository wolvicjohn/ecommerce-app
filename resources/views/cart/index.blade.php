<x-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6 text-white">Your Shopping Cart</h2>

        @if (auth()->check())
            @forelse ($cartItems as $item)
                <div class="cart-form flex flex-col sm:flex-row justify-between items-center mb-6 p-4 bg-white rounded-lg shadow-md border">
                    {{-- Product Info --}}
                    <div class="w-full sm:w-2/3 flex items-center gap-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->productname }}</h3>
                            <p class="text-sm text-gray-500">₱{{ number_format($item->product->price, 2) }} each</p>
                            <p class="text-sm text-gray-600">Quantity: <span class="font-medium">{{ $item->quantity }}</span></p>
                        </div>
                    </div>

                    {{-- Subtotal + Cancel --}}
                    <div class="w-full sm:w-1/3 mt-4 sm:mt-0 flex flex-col sm:items-end text-right">
                        <p class="text-md text-gray-700 font-semibold mb-2">
                            Subtotal: ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                        </p>
                        <form action="{{ route('carts.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 border border-red-500 rounded hover:bg-red-100 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Your cart is empty.</p>
            @endforelse

        @else
            @forelse ($cartItems as $id => $item)
                <div class="cart-form flex flex-col sm:flex-row justify-between items-center mb-6 p-4 bg-white rounded-lg shadow-md border">
                    {{-- Product Info --}}
                    <div class="w-full sm:w-2/3 flex items-center gap-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $item['productname'] }}</h3>
                            <p class="text-sm text-gray-500">₱{{ number_format($item['price'], 2) }} each</p>
                            <p class="text-sm text-gray-600">Quantity: <span class="font-medium">{{ $item['quantity'] }}</span></p>
                        </div>
                    </div>

                    {{-- total  --}}
                    <div class="w-full sm:w-1/3 mt-4 sm:mt-0 flex flex-col sm:items-end text-right">
                        <p class="text-md text-gray-700 font-semibold mb-2">
                            Subtotal: ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </p>
                        <form action="{{ route('carts.removeGuestItem') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 border border-red-500 rounded hover:bg-red-100 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Your cart is empty.</p>
            @endforelse
        @endif
    </div>


    <br>
    <div style="display: flex; justify-content: center">
        @if(count($cartItems) > 0)
            @auth
                <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <button id="checkout-btn" type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded">
                        Place Order
                    </button>
                </form>
            @else
                @php
                    session(['url.intended' => route('carts.index')]);
                @endphp
                <a href="{{ route('login') }}"
                class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Log in to place order
                </a>
            @endauth
        @endif
    </div>



</x-layout>
