<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
{
    $orders = Order::with('product')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('history.index', compact('orders'));
}

}
