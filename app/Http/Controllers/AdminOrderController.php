<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Chat;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->get();

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }

public function show($id)
{
    $order = Order::with('items')->findOrFail($id);

    return view('admin.orders.show', compact('order'));
}

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => request('status')
        ]);

        return back();
    }
}
