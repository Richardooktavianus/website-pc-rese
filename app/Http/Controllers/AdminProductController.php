<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    // =========================
    // LIST PRODUCT
    // =========================

    public function index()
    {
        $products = Product::latest()->get();

        return view(
            'admin.products.index',
            compact('products')
        );
    }

    // =========================
    // CREATE PAGE
    // =========================

   public function create()
{
    $categories = Category::all();

    return view(
        'admin.products.create',
        compact('categories')
    );
}

    // =========================
    // STORE PRODUCT
    // =========================

public function store(Request $request)
{
    $request->validate([

        'name' => 'required',

        'category_id' => 'required',

        'brand' => 'required',

        'stock' => 'required|integer',

        'price' => 'required',

        'description' => 'required',

        'image' => 'required',

    ]);

    Product::create([

        'name' => $request->name,

        'category_id' => $request->category_id,

        'brand' => $request->brand,

        'stock' => $request->stock,

        'price' => $request->price,

        'description' => $request->description,

        'image' => $request->image,

    ]);

    return redirect('/admin/products');
}

    // =========================
    // EDIT PAGE
    // =========================

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view(
            'admin.products.edit',
            compact('product')
        );
    }

    // =========================
    // UPDATE PRODUCT
    // =========================

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = [

            'name' => $request->name,

            'price' => $request->price,

            'description' => $request->description,

        ];

        if ($request->image) {

            $data['image'] = $request->image;
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index');
    }

    // =========================
    // DELETE PRODUCT
    // =========================

    public function delete($id)
    {
        Product::findOrFail($id)->delete();

        return back();
    }
}