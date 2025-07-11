<x-layout>
        @php
        $cartCount = \App\Http\Controllers\CartController::getCartCount();
        @endphp
        <div class="hero-banner">
            <img src="{{ asset('images/ww.jpg') }}" alt="Logo">
            <div class="hero-text">
                <h1>Welcome to TECHSTORE</h1>
                <p>Buy your dream gadgets with us!</p>
            </div>
        </div>

        <br>
        {{-- add product btn show only for admin --}}
        <div class="btn">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('products.create') }}"  class="cart-btn">
                        Add Product
                    </a>

                    <a href="{{ route('categories.create') }}"  class="cart-btn">+ Add New Category</a>
                @else
                    <a href="{{ route('carts.index') }}" class="cart-btn">
                        <i class="fa fa-shopping-cart"></i>
                        <span id="cart-counter" style="color: green">{{ $cartCount }}</span>
                    </a>
                 
                    <a href="{{ route('history.index') }}" class="cart-btn">
                        <i class="fa fa-list-alt"></i>
                        Purchase History</a>
                @endif
            @endauth

            @guest
                <a href="{{ route('carts.index') }}" class="cart-btn">
                    <i class="fa fa-shopping-cart" ></i>
                    <span id="cart-counter" style="color: #38a169">{{ $cartCount }}</span>
                </a>
            @endguest
        </div>

        @foreach ($categories as $category)
            @if ($category->products->count())
                <h2 class="text-2xl font-bold mt-8 mb-4 text-white pl-10">{{ $category->name }}</h2>

                <div class="product-grid">
                    @foreach ($category->products as $product)
                        <div class="product-card">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                            @endif

                            <div class="flex-grow">
                                <h2>{{ $product->productname }}</h2>
                                <ul>
                                    <li><span>➤</span> Category: {{ $product->category->name ?? 'Uncategorized' }}</li>
                                    <li><span>➤</span> Stock: {{ $product->quantity }}</li>
                                </ul>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="product-price">
                                    ₱{{ number_format($product->price, 2) }}
                                </span>

                                @guest
                                    <form class="add-to-cart-form" data-id="{{ $product->id }}">
                                        @csrf
                                        <button type="submit" class="buy-now-btn">Buy Now</button>
                                    </form>
                                @else
                                    @if (!auth()->user()->isAdmin())
                                        <form class="add-to-cart-form" data-id="{{ $product->id }}">
                                            @csrf
                                            <button type="submit" class="buy-now-btn">Buy Now</button>
                                        </form>
                                    @endif
                                @endguest
                            </div>

                            @auth
                                @if (auth()->user()->isAdmin())
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach

   


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



 