<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function user()
    {
        $user = Auth::user();
        return view('user', compact('user'));
    }
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
        $query = Product::with('category');

        // fitur search berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products   = $query->get();
        $categories = Category::withCount('products')->get();

        return view('komponen', compact('products', 'categories'));
    }
}
