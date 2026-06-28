<?php

namespace App\Http\Controllers;

use App\Models\SupportChat;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SupportChatController extends Controller
{
    /**
     * Obtener el historial de un chat para el widget público del usuario.
     */
    public function getChat(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return response()->json(['messages' => []]);
        }

        $chat = SupportChat::with('messages')->where('token', $token)->first();

        if (!$chat) {
            return response()->json(['messages' => []]);
        }

        return response()->json([
            'status' => $chat->status,
            'messages' => $chat->messages
        ]);
    }

    /**
     * Enviar un mensaje desde el widget público del usuario.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'token' => 'nullable|string',
        ]);

        $token = $request->input('token');
        $chat = null;

        if ($token) {
            $chat = SupportChat::where('token', $token)->first();
        }

        if (!$chat) {
            // Crear una nueva conversación
            $token = Str::random(40);
            $chat = SupportChat::create([
                'token' => $token,
                'status' => 'pending'
            ]);
        } else {
            // Actualizar estado a pendiente si el usuario vuelve a escribir
            $chat->update(['status' => 'pending']);
        }

        // Crear el mensaje
        SupportMessage::create([
            'support_chat_id' => $chat->id,
            'sender' => 'user',
            'message' => $request->input('message')
        ]);

        // Cargar los mensajes ordenados
        $chat->load('messages');

        return response()->json([
            'success' => true,
            'token' => $token,
            'status' => $chat->status,
            'messages' => $chat->messages
        ]);
    }

    /**
     * Listar todas las conversaciones en el panel administrativo (Inertia).
     */
    public function adminIndex()
    {
        $chats = SupportChat::with(['messages'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END ASC") // Pendientes primero
            ->orderBy('updated_at', 'desc')
            ->get();

        return Inertia::render('SupportChats', [
            'chats' => $chats,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }

    /**
     * Responder a una conversación desde el panel administrativo (Inertia).
     */
    public function adminReply(Request $request, SupportChat $chat)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        SupportMessage::create([
            'support_chat_id' => $chat->id,
            'sender' => 'admin',
            'message' => $request->input('message')
        ]);

        $chat->update(['status' => 'replied']);

        return redirect()->back()->with('success', 'Respuesta enviada con éxito.');
    }

    /**
     * Eliminar una conversación completa.
     */
    public function adminDestroy(SupportChat $chat)
    {
        $chat->delete();
        return redirect()->back()->with('success', 'Conversación eliminada con éxito.');
    }
}
