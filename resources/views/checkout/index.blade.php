<x-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-center text-2xl font-bold mb-4 text-white">Checkout Page</h2>

        <div class="mb-6">
            <h3 class="text-center text-xl font-semibold mb-2">Cart Summary</h3>

            @php $total = 0; @endphp

            @auth
                @if(isset($cartItems) && $cartItems->count() > 0)
                    <table class="w-full text-left border border-gray-300 bg-white text-black rounded">
                        <thead>
                            <tr class="border-b">
                                <th class="px-4 py-2 bg-white text-black">Product</th>
                                <th class="px-4 py-2 bg-white text-black">Quantity</th>
                                <th class="px-4 py-2 bg-white text-black">Price</th>
                                <th class="px-4 py-2 bg-white text-black">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr class="border-b">
                                    <td class="px-4 py-2 bg-white text-black">{{ $item->product->productname }}</td>
                                    <td class="px-4 py-2 bg-white text-black">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2 bg-white text-black">₱{{ number_format($item->product->price, 2) }}</td>
                                    <td class="px-4 py-2 bg-white text-black">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Place Order Form --}}
                    <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <button id="checkout-btn" type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded">
                            Place Order
                        </button>
                    </form>
                @else
                    <div class="text-center text-gray-400 mt-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-20 w-20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10-9l2 9m-6-9v9" />
                        </svg>
                        <p class="text-xl">Your checkout is empty.</p>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</x-layout>
