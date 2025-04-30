<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMessageController extends Controller
{
    /**
     * Affiche la liste des conversations.
     */
    public function index()
    {
        $conversations = Conversation::with(['userOne', 'userTwo', 'vehicle'])
            ->orderBy('last_message_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('conversations'));
    }

    /**
     * Affiche une conversation spécifique.
     */
    public function show(Conversation $conversation)
    {
        $messages = Message::where('conversation_id', $conversation->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        // Marquer tous les messages comme lus
        if (\Schema::hasColumn('messages', 'read_at')) {
            Message::where('conversation_id', $conversation->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('admin.messages.show', compact('conversation', 'messages'));
    }

    /**
     * Supprime une conversation.
     */
    public function destroy(Conversation $conversation)
    {
        // Supprimer d'abord tous les messages associés
        Message::where('conversation_id', $conversation->id)->delete();
        
        // Puis supprimer la conversation
        $conversation->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Conversation supprimée avec succès.');
    }

    /**
     * Affiche les statistiques des messages.
     */
    public function statistics()
    {
        $totalConversations = Conversation::count();
        $totalMessages = Message::count();
        
        $messagesPerDay = Message::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
            
        $topUsers = User::withCount(['conversationsAsUserOne', 'conversationsAsUserTwo'])
            ->orderByRaw('conversations_as_user_one_count + conversations_as_user_two_count DESC')
            ->limit(10)
            ->get();

        return view('admin.messages.statistics', compact(
            'totalConversations', 
            'totalMessages', 
            'messagesPerDay', 
            'topUsers'
        ));
    }
}
