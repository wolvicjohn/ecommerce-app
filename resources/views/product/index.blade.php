<x-layout>
        <h1>Products</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-title">{{ $product->productname }}</div>
                    <div class="product-category">Category: {{ $product->category }}</div>
                    <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                    <div class="product-quantity">Stock Available: {{ $product->quantity }}</div>

                    <form class="add-to-cart-form" data-id="{{ $product->id }}">
                        @csrf
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
         @endforeach

    </div>
</x-layout>
 