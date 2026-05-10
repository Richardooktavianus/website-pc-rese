<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    ublic function loginPage()
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
}