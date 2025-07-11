<x-layout>
        <div class="add-product-container">
            <h1 class="form-title">Add New Product</h1>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
                @csrf

                <div class="form-group">
                    <label>Product Image</label>
                    <input type="file" name="image" />
                </div>

                <div class="form-group">
                    <label for="productname">Product Name</label>
                    <input type="text" name="productname" id="productname" />
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" />
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" name="price" id="price" />
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="submit-btn">Save Product</button>
            </form>
        </div>
</x-layout>
