<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();
        } else {
            $cartItems = session()->get('cart', []); 
        }

        return view('cart.index', compact('cartItems'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
                'product_id' => ['required','exists:products,id']
            ]);
            $productId = $request->input('product_id');

            // loggedin
            if (auth()->check()) {
                $userId = auth()->id();

                $cartItem = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('quantity');
                } else {
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'quantity' => 1,
                    ]);
                }
            } 
            // not loggedin
            else {
                $cart = session()->get('cart', []);

                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += 1;
                } else {
                    $product = Product::findOrFail($productId);
                    $cart[$productId] = [
                        'productname' => $product->productname,
                        'price' => $product->price,
                        'quantity' => 1,
                    ];
                }

                session()->put('cart', $cart);
            }

            if ($request->ajax()) {
                $cartCount = auth()->check()
                    ? Cart::where('user_id', auth()->id())->sum('quantity')
                    : collect(session('cart', []))->sum('quantity');

                return response()->json([
                    'message' => 'Product added to cart!',
                    'cartCount' => $cartCount
                ]);
            }

        return back()->with('message', 'Product added to cart!');

        // store transaction in history
        foreach ($cart as $productId => $details) {
            Order::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => $details['quantity'],
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
        }

        $cart->delete();

        return redirect()->route('carts.index')->with('message', 'Item removed from cart.');
    }

    // cart counter
    public static function getCartCount()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            $count = 0;
            foreach ($cart as $item) {
                $count += $item['quantity'];
            }
            return $count;
            
        }
    }

    public function removeGuestItem(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return redirect()->back()->with('message', 'Item removed from cart.');
    }


}
