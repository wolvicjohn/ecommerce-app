<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['products' => function ($query) {
                $query->where('quantity', '>', 0);
            }])->get();

            return view('product.index', compact('categories'));

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = Category::all();
        return view('product.create', compact('categories'));

        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'productname' => ['required','string'],
            'quantity' => ['required','integer'],
            'price' => ['required', 'numeric', 'between:0,999999.99'],
            'category_id' => ['required', 'exists:categories,id'], 
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $data['image'] = $imagePath;
        }
            Product::create($data);        
            return redirect()->route('products.index')->with('message', 'New product added');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show',['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit',['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {   
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
