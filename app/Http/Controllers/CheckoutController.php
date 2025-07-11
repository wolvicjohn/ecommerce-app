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
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)->get();

        // if ($cartItems->isEmpty()) {
        //     return redirect()->route('products.index');
        // }

        foreach ($cartItems as $item) {
            Order::create([
                'user_id' => $userId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }

        Cart::where('user_id', $userId)->delete();

        return redirect()->route('history.index')->with('success', 'Order placed successfully!');
    }
}
