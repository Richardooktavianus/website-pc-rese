<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category; // 

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::all();
        return view('home', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // ambil produk lain (random, selain yang sedang dibuka)
        $recommended = Product::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'recommended'));
    }

    public function komponen(Request $request)
    {
        $products   = Product::with('category')->get();
        $categories = Category::withCount('products')->get();

        return view('komponen', compact('products', 'categories'));
    }
}
