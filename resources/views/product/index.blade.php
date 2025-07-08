<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        <a href="{{ route('products.create') }}" class="add-product-btn">
            <i class="fas fa-plus" style="margin-right: 6px;"></i> 
            Add Product
        </a>

        <a href="{{ route('products.create') }}" class = "cart-btn">
            cart
        </a>

        <h1>Products</h1>
        @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-title">{{ $product->productname }}</div>
                    <div class="product-category">Category: {{ $product->category }}</div>
                    <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                    <div class="product-quantity">Stock Available: {{ $product->quantity }}</div>
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
         @endforeach

    </div>
</x-layout>
 