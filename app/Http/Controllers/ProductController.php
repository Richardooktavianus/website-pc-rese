<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
{
    $products = \App\Models\Product::all();
    return view('home', compact('products'));
}

   public function show($id)
{
    $product = \App\Models\Product::findOrFail($id);

    return view('product-detail', compact('product'));
}
}
