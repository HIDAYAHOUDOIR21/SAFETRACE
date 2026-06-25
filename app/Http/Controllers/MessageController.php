<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages_recus = Message::where('receiver_id', Auth::id())
                                  ->with('sender', 'annonce')
                                  ->latest()
                                  ->get();

        $messages_envoyes = Message::where('sender_id', Auth::id())
                                    ->with('receiver', 'annonce')
                                    ->latest()
                                    ->get();

        return view('messages', compact('messages_recus', 'messages_envoyes'));
    }

    public function create($user_id, $annonce_id = null)
    {
        $destinataire = User::findOrFail($user_id);
        $annonce = $annonce_id ? Annonce::find($annonce_id) : null;
        return view('create_message', compact('destinataire', 'annonce'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'annonce_id' => $request->annonce_id,
            'contenu' => $request->contenu,
            'lu' => false,
        ]);

        return redirect('/messages')->with('success', 'Message envoyé avec succès !');
    }

    public function marquerLu($id)
    {
        $message = Message::findOrFail($id);
        if($message->receiver_id == Auth::id()) {
            $message->update(['lu' => true]);
        }
        return back();
    }
}