<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    // 🔥 HAPUS 1 BUILD
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        unset($cart[$request->index]);

        session()->put('cart', array_values($cart));

        return back();
    }

    // 🔥 KOSONGKAN CART
    public function clear()
    {
        session()->forget('cart');
        return back();
    }

    // 🔥 CHECKOUT (SIMPLE)
   public function checkout()
{
    $cart = session('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Cart kosong!');
    }

    foreach ($cart as $build) {

        // 🔥 SIMPAN ORDER
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $build['total'],
            'status' => 'pending'
        ]);

        // 🔥 SIMPAN ITEM
        foreach ($build['items'] as $component => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'component' => $component,
                'product_name' => $item['name'],
                'price' => $item['price']
            ]);
        }
    }

    // 🔥 HAPUS CART
    session()->forget('cart');

    return redirect('/cart')->with('success', 'Checkout berhasil!');
}
}