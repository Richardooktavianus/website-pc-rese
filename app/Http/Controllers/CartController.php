<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::find($request->product_id);

        $cart = session()->get('cart', []);

        $cart[$product->id] = [
            "name" => $product->name,
            "price" => $product->price,
            "quantity" => 1
        ];

        session()->put('cart', $cart);

        return redirect('/cart');
    }
}
