<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;

class MessageCheckController extends Controller
{
    /**
     * Vérifier les nouveaux messages non lus pour l'utilisateur connecté
     */
    public function checkNewMessages(Request $request)
    {
        // Récupérer les ID des conversations de l'utilisateur
        $conversationIds = Conversation::where('user_one_id', auth()->id())
            ->orWhere('user_two_id', auth()->id())
            ->pluck('id');
        
        // Compter les messages non lus
        $query = Message::whereIn('conversation_id', $conversationIds)
            ->where('user_id', '!=', auth()->id());
            
        // Vérifier si la colonne read_at existe
        if (\Schema::hasColumn('messages', 'read_at')) {
            $query->whereNull('read_at');
        }
        
        $unreadCount = $query->count();
        
        // Récupérer le dernier message reçu
        $lastMessage = Message::whereIn('conversation_id', $conversationIds)
            ->where('user_id', '!=', auth()->id())
            ->latest()
            ->first();
            
        $lastMessageId = $lastMessage ? $lastMessage->id : 0;
        
        return response()->json([
            'unread_count' => $unreadCount,
            'last_message_id' => $lastMessageId
        ]);
    }
}
