<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
{
    $userId = Auth::id();

    $cartItems = Cart::with('product')->where('user_id', $userId)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    foreach ($cartItems as $item) {
        $product = $item->product;

        // Skip if product doesn't exist or stock is insufficient
        if (!$product || $product->quantity < $item->quantity) {
            continue; // or optionally show an error message
        }

        // Create order
        Order::create([
            'user_id' => $userId,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
        ]);

        // Deduct quantity
        $product->quantity -= $item->quantity;
        $product->save();
    }

    // Clear cart
    Cart::where('user_id', $userId)->delete();

    return redirect()->route('history.index')->with('success', 'Order placed successfully!');
}
}
