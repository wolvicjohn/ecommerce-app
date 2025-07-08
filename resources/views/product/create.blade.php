<x-layout>
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

    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Add New Product</h1>

    <form action="{{ route('products.store') }}" method="POST">

        @csrf
        
        <div style="margin-bottom: 15px;">
            <label for="productname">Product Name</label><br>
            <input type="text" name="productname" id="productname">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="quantity">Quantity</label><br>
            <input type="number" name="quantity" id="quantity">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="price">Price</label><br>
            <input type="number" name="price" id="price" step="0.01">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="category">Category</label><br>
            <input type="text" name="category" id="category">
        </div>

        <div>
            <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
            Save Product
        </button>
        </div>
    </form>
</x-layout>
