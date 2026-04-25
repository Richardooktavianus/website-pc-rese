<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
{
    $cart = session()->get('cart', []);
    return view('checkout', compact('cart'));
}

public function process()
{
    $cart = session()->get('cart', []);

    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'];
    }

    $order = Order::create([
        'total_price' => $total,
        'status' => 'pending'
    ]);

    foreach ($cart as $id => $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ]);
    }

    session()->forget('cart');

    return "Checkout berhasil!";
}
}
