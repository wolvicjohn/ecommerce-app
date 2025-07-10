<x-layout>
    <div class="add-product-form">
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('message'))
        <div style="color: green;">
            {{ session('message') }}
        </div>
    @endif

    <h1>Add New Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="product-image">
            <label>Product Image:</label>
            <input type="file" name="image" class="block mb-4" />
        </div>
        
        <div class="product-input">
            <label for="productname">Product Name</label><br>
            <input type="text" name="productname" id="productname">
        </div>

        <div class="product-input">
            <label for="quantity">Quantity</label><br>
            <input type="number" name="quantity" id="quantity">
        </div>

        <div class="product-input">
            <label for="price">Price</label><br>
            <input type="number" name="price" id="price" step="0.01">
        </div>

        <div class="product-input">
            <label for="category">Category</label><br>
            <input type="text" name="category" id="category">
        </div>

        <div>
            <button type="submit" class="submit-product">
            Save Product
        </button>
        </div>
    </form>
</div>
</x-layout>
