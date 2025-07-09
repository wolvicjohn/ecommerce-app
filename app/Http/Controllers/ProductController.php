<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->orderBy('created_at', 'desc')->paginate();
        return view('product.index', ['products'=> $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            'category' => ['required','string'],
        ]);

        try {
            Product::create($data);        
            return redirect()->route('products.index')->with('message', 'New product added');
        } catch (\Throwable $e) {
            \Log::error($e);
            return back()->withErrors(['general' => 'Something went wrong.']);
        }
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
        //
    }
}
