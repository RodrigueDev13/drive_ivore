<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Affiche la liste des conversations de l'utilisateur.
     */
    public function index()
    {
        $conversations = auth()->user()->getLatestMessages();

        return view('messages.index', compact('conversations'));
    }

    /**
     * Affiche une conversation spécifique avec un utilisateur.
     */
    public function show($userId)
    {
        // Récupérer l'autre utilisateur
        $otherUser = User::findOrFail($userId);
        
        // Ajouter des logs pour déboguer
        \Log::info('Affichage conversation avec utilisateur: ' . $userId);
        
        // Créer ou récupérer la conversation
        $conversation = auth()->user()->getOrCreateConversationWith($userId);
        
        // Vérifier si la conversation existe bien
        if (!$conversation) {
            \Log::error('Conversation introuvable pour les utilisateurs: ' . auth()->id() . ' et ' . $userId);
            return redirect()->route('messages.index')->with('error', 'Conversation introuvable.');
        }
        
        \Log::info('Conversation trouvée: ' . $conversation->id);
        \Log::info('user_one_id: ' . $conversation->user_one_id . ', user_two_id: ' . $conversation->user_two_id);
        
        // Charger les relations nécessaires
        $conversation->load('vehicle');
        
        // Récupérer tous les messages de la conversation
        $messages = Message::where('conversation_id', $conversation->id)
            ->with('user') // Charger la relation utilisateur pour chaque message
            ->orderBy('created_at', 'asc')
            ->get();
        
        \Log::info('Nombre de messages trouvés: ' . $messages->count());
        
        // Déboguer les messages
        foreach ($messages as $index => $message) {
            \Log::info("Message {$index}: user_id={$message->user_id}, content={$message->content}");
        }
        
        // Marquer les messages non lus comme lus
        foreach ($messages as $message) {
            if ($message->user_id !== auth()->id()) {
                // La méthode markAsRead() vérifie maintenant si la colonne existe
                $message->markAsRead();
            }
        }

        return view('messages.show', compact('otherUser', 'messages', 'conversation'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau message.
     */
    public function create(Request $request)
    {
        $vehicle = null;
        $users = [];

        if ($request->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            $users = [$vehicle->user];
        } else {
            // Récupérer tous les utilisateurs sauf l'utilisateur actuel
            $users = User::where('id', '!=', auth()->id())->get();
        }

        return view('messages.create', compact('vehicle', 'users'));
    }

    /**
     * Enregistre un nouveau message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        $conversation = auth()->user()->getOrCreateConversationWith(
            $request->recipient_id,
            $request->vehicle_id
        );

        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->user_id = auth()->id();
        $message->content = $request->content;
        $message->save();

        // Mettre à jour la date du dernier message
        $conversation->last_message_at = now();
        $conversation->save();

        return redirect()->route('messages.show', $request->recipient_id)
            ->with('success', 'Message envoyé avec succès !');
    }

    /**
     * Répond à un message dans une conversation existante.
     */
    public function reply(Request $request, $userId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $conversation = auth()->user()->getOrCreateConversationWith($userId);

        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->user_id = auth()->id();
        $message->content = $request->content;
        $message->save();

        // Mettre à jour la date du dernier message
        $conversation->last_message_at = now();
        $conversation->save();

        return redirect()->route('messages.show', $userId)
            ->with('success', 'Réponse envoyée avec succès !');
    }
}
