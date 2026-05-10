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
        return response()->json(

            Chat::where('user_id', Auth::id())
                ->orderBy('created_at')
                ->get()

        );
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender' => 'user',
        ]);

        return response()->json([
            'success' => true
        ]);
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
        $request->validate([
            'message' => 'required'
        ]);

        Chat::create([
            'user_id' => $userId,
            'message' => $request->message,
            'sender' => 'admin',
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}