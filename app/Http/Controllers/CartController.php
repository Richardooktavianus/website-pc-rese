<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // ✅ Tambah produk satuan ke cart
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity  = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        // Cek apakah produk sudah ada
        $existingKey = null;
        foreach ($cart as $key => $build) {
            if (isset($build['product_id']) && $build['product_id'] == $productId) {
                $existingKey = $key;
                break;
            }
        }

        if ($existingKey !== null) {
            $cart[$existingKey]['items'][$product->name]['quantity'] += $quantity;
            $cart[$existingKey]['total'] = $product->price * $cart[$existingKey]['items'][$product->name]['quantity'];
        } else {
            $cart[] = [
                'type'       => 'product',
                'product_id' => $productId,
                'image'      => $product->image ?? null,
                'category'   => optional($product->category)->name,
                'brand'      => optional($product->brand)->name,
                'items'      => [
                    $product->name => [
                        'name'     => $product->name,
                        'price'    => $product->price,
                        'quantity' => $quantity,
                    ]
                ],
                'total' => $product->price * $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect('/cart')->with('cart_added', $product->name);
    }

    // 🔥 Hapus 1 item
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->index]);
        session()->put('cart', array_values($cart));
        return back()->with('success', 'Item berhasil dihapus.');
    }

    // 🗑 Hapus item terpilih (bulk delete dari checkbox)
    public function removeSelected(Request $request)
    {
        $indexes = $request->input('indexes', []);

        if (empty($indexes)) {
            return back()->with('error', 'Tidak ada item yang dipilih.');
        }

        $cart    = session()->get('cart', []);
        $indexes = array_map('intval', $indexes);
        rsort($indexes); // hapus dari belakang agar index tidak bergeser

        foreach ($indexes as $idx) {
            if (isset($cart[$idx])) {
                unset($cart[$idx]);
            }
        }

        session()->put('cart', array_values($cart));

        $count = count($indexes);
        return back()->with('success', $count . ' item berhasil dihapus dari keranjang.');
    }

    // 🔥 Kosongkan semua cart
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}