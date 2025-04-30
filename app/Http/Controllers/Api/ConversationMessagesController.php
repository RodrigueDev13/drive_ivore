<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;

class ConversationMessagesController extends Controller
{
    /**
     * Récupérer les nouveaux messages d'une conversation depuis un ID spécifique
     */
    public function getNewMessages(Request $request, $conversationId)
    {
        // Vérifier si l'utilisateur a accès à cette conversation
        $conversation = Conversation::where('id', $conversationId)
            ->where(function($query) {
                $query->where('user_one_id', auth()->id())
                      ->orWhere('user_two_id', auth()->id());
            })
            ->first();
            
        if (!$conversation) {
            return response()->json(['error' => 'Conversation non trouvée'], 404);
        }
        
        // Récupérer l'ID du dernier message vu
        $lastMessageId = $request->query('since', 0);
        
        // Récupérer les nouveaux messages
        $newMessages = Message::where('conversation_id', $conversationId)
            ->where('id', '>', $lastMessageId)
            ->where('user_id', '!=', auth()->id())
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();
            
        return response()->json([
            'new_messages' => $newMessages
        ]);
    }
}
