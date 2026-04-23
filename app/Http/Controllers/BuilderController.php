<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class BuilderController extends Controller
{
    public function index()
    {
        return view('builder', [
            'cpu' => Product::whereHas('category', fn($q) => $q->where('name', 'Processor'))->get(),
            'gpu' => Product::whereHas('category', fn($q) => $q->where('name', 'VGA'))->get(),
            'ram' => Product::whereHas('category', fn($q) => $q->where('name', 'RAM'))->get(),
            'motherboard' => Product::whereHas('category', fn($q) => $q->where('name', 'Motherboard'))->get(),
            'ssd' => Product::whereHas('category', fn($q) => $q->where('name', 'SSD'))->get(),
            'hdd' => Product::whereHas('category', fn($q) => $q->where('name', 'HDD'))->get(),
            'case' => Product::whereHas('category', fn($q) => $q->where('name', 'Casing'))->get(),
            'cooler' => Product::whereHas('category', fn($q) => $q->where('name', 'Cooler'))->get(),
            'fan' => Product::whereHas('category', fn($q) => $q->where('name', 'Fan'))->get(),
            'psu' => Product::whereHas('category', fn($q) => $q->where('name', 'Power Supply'))->get(),
        ]);
    }

    public function addToCart(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'cpu' => 'required|exists:products,id',
            'gpu' => 'required|exists:products,id',
            'ram' => 'required|exists:products,id',
            'motherboard' => 'required|exists:products,id',
            'psu' => 'required|exists:products,id',
            'ssd' => 'nullable|required_without:hdd|exists:products,id',
            'hdd' => 'nullable|required_without:ssd|exists:products,id',
        ]);

        // 🔹 AMBIL DATA PRODUK
        $cpu = Product::find($request->cpu);
        $gpu = Product::find($request->gpu);
        $ram = Product::find($request->ram);
        $motherboard = Product::find($request->motherboard);
        $psu = Product::find($request->psu);

        // 🔥 VALIDASI KOMPATIBILITAS

        // CPU vs Motherboard
        if ($cpu && $motherboard && $cpu->socket !== $motherboard->socket) {
            return response()->json([
                'error' => 'CPU tidak kompatibel dengan motherboard (socket berbeda)'
            ], 400);
        }

        // RAM vs Motherboard
        if ($ram && $motherboard && $ram->ram_type !== $motherboard->ram_type) {
            return response()->json([
                'error' => 'RAM tidak kompatibel dengan motherboard (DDR berbeda)'
            ], 400);
        }

        // GPU vs PSU
        if ($gpu && $psu) {
    if (!$gpu->watt || !$psu->watt) {
        return response()->json([
            'error' => 'Data watt GPU/PSU belum lengkap'
        ], 400);
    }

    if ($gpu->watt > $psu->watt) {
        return response()->json([
            'error' => 'PSU tidak cukup untuk GPU'
        ], 400);
    }
}

        // 🔹 SEMUA KOMPONEN
        $components = [
            'cpu' => $request->cpu,
            'gpu' => $request->gpu,
            'ram' => $request->ram,
            'motherboard' => $request->motherboard,
            'psu' => $request->psu,
            'ssd' => $request->ssd,
            'hdd' => $request->hdd,
            'case' => $request->case,
            'cooler' => $request->cooler,
            'fan' => $request->fan,
        ];

        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];

        foreach ($components as $key => $id) {
            if ($id) {
                $product = Product::find($id);

                if ($product) {
                    $items[$key] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                    ];

                    $total += $product->price;
                }
            }
        }

        // 🔹 SIMPAN KE CART
        $cart[] = [
            'type' => 'build',
            'items' => $items,
            'total' => $total,
        ];

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Build berhasil ditambahkan ke cart',
            'total' => $total,
            'cart_count' => count($cart),
        ]);
    }
}