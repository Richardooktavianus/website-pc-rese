<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Chat;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(
            'email',
            'password'
        );

        // cek role admin
        $credentials['role'] = 'admin';

        if (
            Auth::guard('admin')
                ->attempt($credentials)
        ) {

            return redirect('/admin/chat');
        }

        return back()->with(
            'error',
            'Login gagal'
        );
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }


        public function dashboard()
    {
        $totalUser = User::count();

        $totalProduct = Product::count();

        $totalChat = Chat::count();

        // TOTAL ORDER
        $totalPenjualan = Order::count();

        // TOTAL PENDAPATAN
        $totalPendapatan = Order::sum('total_price');

        // GRAFIK 7 HARI
        $salesData = Order::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->take(7)
            ->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalProduct',
            'totalChat',
            'totalPenjualan',
            'totalPendapatan',
            'salesData'
        ));
    }
}