<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // =========================
    // USER CHAT
    // =========================

    public function index()
    {
        return view('chat.index');
    }

 public function messages()
{
    if (!auth()->check()) {

        return response()->json([]);
    }

    $messages = \App\Models\Chat::where(
        'user_id',
        auth()->id()
    )
    ->orderBy('id', 'asc')
    ->get();

    return response()->json($messages);
}

    public function send(Request $request)
{
    try {

        // validasi
        $request->validate([
            'message' => 'required|string'
        ]);

        // cek login
        if (!auth()->check()) {

            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);

        }

        // simpan chat
        \App\Models\Chat::create([
            'user_id' => auth()->id(),
            'sender'  => 'user',
            'message' => $request->message
        ]);

        return response()->json([
            'success' => true
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);

    }
}

    // =========================
    // ADMIN CHAT
    // =========================

    public function adminIndex()
{
    $users = \App\Models\User::whereHas('chats')

        ->with(['chats' => function($q) {

            $q->latest();

        }])

        ->get();

    return view(
        'admin.chat.index',
        compact('users')
    );
}

    public function adminRoom($userId)
    {
        $user = User::findOrFail($userId);

        return view('admin.chat.room', compact('user'));
    }

    public function adminMessages($userId)
    {
        return response()->json(

            Chat::where('user_id', $userId)
                ->orderBy('created_at')
                ->get()

        );
    }

public function reply(Request $request, $userId)
{
    Chat::create([
        'user_id' => $userId,
        'sender' => 'admin',
        'message' => $request->message
    ]);

    return response()->json([
        'success' => true
    ]);
}
}