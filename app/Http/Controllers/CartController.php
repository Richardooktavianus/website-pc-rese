<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // 🔥 WAJIB

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::find($request->product_id);

        // ❗ cek kalau produk tidak ada
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan!');
        }

        $cart = session()->get('cart', []);

        // ✅ kalau sudah ada, tambah quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // ✅ kalau belum ada, tambah baru
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Berhasil ditambahkan ke keranjang!');
    }
}