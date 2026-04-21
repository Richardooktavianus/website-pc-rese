<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuilderController extends Controller
{
    public function index()
        {
            $cpu = Product::whereHas('category', fn($q) => $q->where('name', 'Processor'))->get();
            $gpu = Product::whereHas('category', fn($q) => $q->where('name', 'VGA'))->get();
            $ram = Product::whereHas('category', fn($q) => $q->where('name', 'RAM'))->get();

            return view('builder', compact('cpu','gpu','ram'));
        }
    public function save(Request $request)
        {
            $total = $request->cpu + $request->gpu + $request->ram;

            return "Total Harga: Rp " . number_format($total);
        }
}
