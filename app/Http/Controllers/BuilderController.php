<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class BuilderController extends Controller
{
    public function index()
    {
        return view('builder', [
            'cpu'         => Product::whereHas('category', fn($q) => $q->where('name', 'CPU'))->get(),
            'gpu'         => Product::whereHas('category', fn($q) => $q->where('name', 'GPU'))->get(),
            'ram'         => Product::whereHas('category', fn($q) => $q->where('name', 'RAM'))->get(),
            'motherboard' => Product::whereHas('category', fn($q) => $q->where('name', 'Motherboard'))->get(),
            'ssd'         => Product::whereHas('category', fn($q) => $q->where('name', 'SSD'))->get(),
            'hdd'         => Product::whereHas('category', fn($q) => $q->where('name', 'HDD'))->get(),
            'case'        => Product::whereHas('category', fn($q) => $q->where('name', 'Casing'))->get(),
            'cooler'      => Product::whereHas('category', fn($q) => $q->where('name', 'Cooling'))->get(),
            'fan'         => Product::whereHas('category', fn($q) => $q->where('name', 'Fan'))->get(),
            'psu'         => Product::whereHas('category', fn($q) => $q->where('name', 'PSU'))->get(),
        ]);
    }

    public function addToCart(Request $request)
    {
        // Validasi dengan pesan error yang jelas
        $validator = Validator::make($request->all(), [
            'cpu'         => 'required|exists:products,id',
            'gpu'         => 'required|exists:products,id',
            'ram'         => 'required|exists:products,id',
            'motherboard' => 'required|exists:products,id',
            'psu'         => 'required|exists:products,id',
            'ssd'         => 'nullable|required_without:hdd|exists:products,id',
            'hdd'         => 'nullable|required_without:ssd|exists:products,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $pesan  = [];

            if ($errors->has('cpu'))                      $pesan[] = 'CPU wajib dipilih';
            if ($errors->has('gpu'))                      $pesan[] = 'GPU wajib dipilih';
            if ($errors->has('ram'))                      $pesan[] = 'RAM wajib dipilih';
            if ($errors->has('motherboard'))              $pesan[] = 'Motherboard wajib dipilih';
            if ($errors->has('psu'))                      $pesan[] = 'PSU wajib dipilih';
            if ($errors->has('ssd') || $errors->has('hdd')) $pesan[] = 'Minimal pilih SSD atau HDD';

            return response()->json(['error' => implode(', ', $pesan)], 422);
        }

        // Ambil data produk
        $cpu         = Product::find($request->cpu);
        $gpu         = Product::find($request->gpu);
        $ram         = Product::find($request->ram);
        $motherboard = Product::find($request->motherboard);
        $psu         = Product::find($request->psu);

        // Cek kompatibilitas CPU vs Motherboard
        if ($cpu && $motherboard && $cpu->socket && $motherboard->socket) {
            if ($cpu->socket !== $motherboard->socket) {
                return response()->json([
                    'error' => 'CPU tidak kompatibel dengan Motherboard (socket berbeda: ' . $cpu->socket . ' vs ' . $motherboard->socket . ')'
                ], 400);
            }
        }

        // Cek kompatibilitas RAM vs Motherboard
        if ($ram && $motherboard && $ram->ram_type && $motherboard->ram_type) {
            if ($ram->ram_type !== $motherboard->ram_type) {
                return response()->json([
                    'error' => 'RAM tidak kompatibel dengan Motherboard (tipe berbeda: ' . $ram->ram_type . ' vs ' . $motherboard->ram_type . ')'
                ], 400);
            }
        }

        // Cek GPU vs PSU (hanya jika data watt tersedia)
        if ($gpu && $psu && $gpu->watt && $psu->watt) {
            if ($gpu->watt > $psu->watt) {
                return response()->json([
                    'error' => 'PSU tidak cukup untuk GPU (butuh min. ' . $gpu->watt . 'W, PSU kamu ' . $psu->watt . 'W)'
                ], 400);
            }
        }

        // Susun semua komponen
        $components = [
            'cpu'         => $request->cpu,
            'gpu'         => $request->gpu,
            'ram'         => $request->ram,
            'motherboard' => $request->motherboard,
            'psu'         => $request->psu,
            'ssd'         => $request->ssd,
            'hdd'         => $request->hdd,
            'case'        => $request->case,
            'cooler'      => $request->cooler,
            'fan'         => $request->fan,
        ];

        $cart  = session()->get('cart', []);
        $total = 0;
        $items = [];

        foreach ($components as $key => $id) {
            if ($id) {
                $product = Product::find($id);
                if ($product) {
                    $items[$key] = [
                        'id'    => $product->id,
                        'name'  => $product->name,
                        'price' => $product->price,
                    ];
                    $total += $product->price;
                }
            }
        }

        $cart[] = [
            'type'  => 'build',
            'items' => $items,
            'total' => $total,
        ];

        session()->put('cart', $cart);

        return response()->json([
            'success'    => true,
            'message'    => 'Build berhasil ditambahkan ke cart',
            'total'      => $total,
            'cart_count' => count($cart),
        ]);
    }
}