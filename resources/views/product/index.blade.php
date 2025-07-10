<x-layout>
        @php
        $cartCount = \App\Http\Controllers\CartController::getCartCount();
        @endphp
        <br>
        {{-- add product btn show only for admin --}}
        <div class="btn">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Add Product
                    </a>
                @else
                    <a href="{{ route('carts.index') }}" class="cart-btn">
                        <i class="fa fa-shopping-cart"></i>
                        <span id="cart-counter" style="color: blue">{{ $cartCount }}</span>
                    </a>
                 
                    <a href="{{ route('history.index') }}" class="btn">View Purchase History</a>
                @endif
            @endauth

            @guest
                <a href="{{ route('carts.index') }}" class="cart-btn">
                    <i class="fa fa-shopping-cart" ></i>
                    <span id="cart-counter" style="color: blue">{{ $cartCount }}</span>
                </a>
            @endguest
        </div>
        <h1>Products</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        @foreach ($products as $product)
            <div class="product-card">
                <div>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-32 h-32 object-cover mb-2">
                @endif </div><div>
                <div class="product-title">{{ $product->productname }}</div>
                <div class="product-category">Category: {{ $product->category }}</div>
                <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                <div class="product-quantity">Stock Available: {{ $product->quantity }}</div>
                    </div>
                <form class="add-to-cart-form" data-id="{{ $product->id }}">
                    @csrf
                    <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                </form>

                @auth
                    @if (auth()->user()->isAdmin())
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" style="margin-top: 10px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                        </form>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); 

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); 
                        }
                    });
                });
            });
        });
    </script>

</x-layout>



 