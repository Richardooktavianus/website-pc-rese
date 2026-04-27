<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ambil chat user login
    public function getChat()
    {
        return Chat::where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();
    }

    // untuk popup (global / sementara)
    public function get()
    {
        return Chat::latest()->take(20)->get()->reverse()->values();
    }

    // kirim pesan user
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender' => 'user'
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function reply(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        Chat::create([
            'user_id' => $userId,
            'message' => $request->message,
            'sender' => 'admin'
        ]);

        return response()->json(['status' => 'ok']);
    }
}
