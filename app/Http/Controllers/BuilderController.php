<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // ✅ WAJIB

class BuilderController extends Controller
{
    public function index()
    {
        $cpu = Product::whereHas('category', fn($q) => $q->where('name', 'Processor'))->get();
        $gpu = Product::whereHas('category', fn($q) => $q->where('name', 'VGA'))->get();
        $ram = Product::whereHas('category', fn($q) => $q->where('name', 'RAM'))->get();

        return view('builder', compact('cpu', 'gpu', 'ram'));
    }

    public function calc(Request $request)
    {
        $cpu = Product::find($request->cpu);
        $gpu = Product::find($request->gpu);
        $ram = Product::find($request->ram);

        // ❗ cek kalau ada yang kosong
        if (!$cpu || !$gpu || !$ram) {
            return back()->with('error', 'Pilih semua komponen!');
        }

        // ✅ hitung total harga
        $total = $cpu->price + $gpu->price + $ram->price;

        return view('builder-result', compact('cpu', 'gpu', 'ram', 'total'));
    }
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $cart[] = [
            'cpu' => $request->cpu,
            'gpu' => $request->gpu,
            'ram' => $request->ram,
            'type' => 'build'
        ];

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }
}