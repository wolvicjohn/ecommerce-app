<x-layout>
    <div class="category-page">
        <div class="category-form-box">
            <h2>Add New Category</h2>

            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Category Name" required>
                <button type="submit">Add Category</button>
            </form>
        </div>

        <div class="category-table-box">
            <h2>Category List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Action</th> {{-- New column for the button --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
