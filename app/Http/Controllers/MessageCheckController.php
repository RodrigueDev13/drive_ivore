<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;

class MessageCheckController extends Controller
{
    /**
     * Vérifier les nouveaux messages
     */
    public function checkNewMessages(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Non autorisé'], 401);
        }
        
        // Récupérer l'ID du dernier message vu
        $lastMessageId = $request->query('last_id', 0);
        $conversationId = $request->query('conversation_id', null);
        
        // Récupérer les conversations de l'utilisateur (optimisé)
        $conversationsQuery = Conversation::select('id')
            ->where(function($query) {
                $query->where('user_one_id', auth()->id())
                      ->orWhere('user_two_id', auth()->id());
            });
        
        // Si un ID de conversation spécifique est fourni, filtrer par cet ID
        if ($conversationId) {
            $conversationsQuery->where('id', $conversationId);
        }
        
        $conversations = $conversationsQuery->pluck('id');
            
        // Optimisation: utiliser une seule requête pour compter les messages non lus
        $unreadCount = 0;
        if (\Schema::hasColumn('messages', 'read_at')) {
            $unreadCount = Message::whereIn('conversation_id', $conversations)
                ->where('user_id', '!=', auth()->id())
                ->whereNull('read_at')
                ->count();
        }
        
        // Vérifier s'il y a des messages plus récents que le dernier ID
        $hasNewMessages = false;
        $lastMessageTime = 0;
        
        if ($lastMessageId > 0) {
            // Optimisation: utiliser une seule requête pour vérifier les nouveaux messages
            $newMessages = Message::whereIn('conversation_id', $conversations)
                ->where('user_id', '!=', auth()->id())
                ->where('id', '>', $lastMessageId)
                ->count();
                
            $hasNewMessages = $newMessages > 0;
            
            // Récupérer l'horodatage du dernier message seulement si nécessaire
            if ($hasNewMessages) {
                $lastMessage = Message::whereIn('conversation_id', $conversations)
                    ->latest()
                    ->first(['created_at']);
                    
                if ($lastMessage) {
                    $lastMessageTime = strtotime($lastMessage->created_at) * 1000; // Convertir en millisecondes
                }
            }
        }
        
        return response()->json([
            'unread_count' => $unreadCount,
            'has_new_messages' => $hasNewMessages,
            'last_message_time' => $lastMessageTime
        ]);
    }
}
