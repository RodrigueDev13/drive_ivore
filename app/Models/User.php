<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_seller',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the vehicles that belong to the user.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get the user's favorite vehicles.
     */
    public function favorites()
    {
        return $this->belongsToMany(Vehicle::class, 'favorites', 'user_id', 'vehicle_id')
            ->withTimestamps();
    }

    /**
     * Get conversations where the user is user_one.
     */
    public function conversationsAsUserOne()
    {
        return $this->hasMany(Conversation::class, 'user_one_id');
    }

    /**
     * Get conversations where the user is user_two.
     */
    public function conversationsAsUserTwo()
    {
        return $this->hasMany(Conversation::class, 'user_two_id');
    }

    /**
     * Get all conversations for the user.
     */
    public function conversations()
    {
        // 1. Récupérer les conversations où l'utilisateur est soit user_one_id, soit user_two_id
        $conversationsAsUser = Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
            
        // 2. Récupérer également les conversations où l'utilisateur a envoyé un message
        $sentMessageConversationIds = Message::where('user_id', $this->id)
            ->distinct()
            ->pluck('conversation_id');
            
        // 3. Récupérer les conversations où l'utilisateur a reçu un message
        $receivedMessageConversationIds = Message::where('user_id', '!=', $this->id)
            ->whereIn('conversation_id', function($query) {
                $query->select('id')
                      ->from('conversations')
                      ->where('user_one_id', $this->id)
                      ->orWhere('user_two_id', $this->id);
            })
            ->distinct()
            ->pluck('conversation_id');
        
        // 4. Combiner toutes les conversations
        $allConversationIds = $sentMessageConversationIds->merge($receivedMessageConversationIds);
        
        if ($allConversationIds->count() > 0) {
            $conversationsAsUser->orWhereIn('id', $allConversationIds);
        }
        
        // 5. Ajouter des logs pour déboguer
        \Log::info('User ID: ' . $this->id . ' - Conversations count: ' . $conversationsAsUser->count());
            
        return $conversationsAsUser->orderBy('last_message_at', 'desc')->get();
    }

    /**
     * Get the latest messages for each conversation the user is part of.
     */
    public function getLatestMessages()
    {
        $conversations = $this->conversations();
        $result = [];
        $userConversations = [];

        foreach ($conversations as $conversation) {
            $latestMessage = Message::where('conversation_id', $conversation->id)
                ->latest()
                ->first();

            if ($latestMessage) {
                // Trouver l'autre utilisateur à partir des champs user_one_id et user_two_id
                $otherUser = null;
                if ($conversation->user_one_id == $this->id) {
                    $otherUser = User::find($conversation->user_two_id);
                } elseif ($conversation->user_two_id == $this->id) {
                    $otherUser = User::find($conversation->user_one_id);
                } else {
                    // Fallback: chercher dans les messages (pour la compatibilité avec les anciennes conversations)
                    $otherUserIds = Message::where('conversation_id', $conversation->id)
                        ->where('user_id', '!=', $this->id)
                        ->distinct()
                        ->pluck('user_id');
                    
                    if ($otherUserIds->count() > 0) {
                        $otherUser = User::find($otherUserIds->first());
                    }
                }
                
                if (!$otherUser) {
                    continue; // Ignorer cette conversation si on ne trouve pas l'autre utilisateur
                }
                
                // Compter les messages non lus de cet utilisateur
                $query = Message::where('conversation_id', $conversation->id)
                    ->where('user_id', '!=', $this->id);
                    
                // Vérifier si la colonne read_at existe dans la table
                if (\Schema::hasColumn('messages', 'read_at')) {
                    $query->whereNull('read_at');
                }
                
                $unreadCount = $query->count();
                
                // Stocker la conversation la plus récente pour chaque utilisateur
                $userId = $otherUser->id;
                
                if (!isset($userConversations[$userId]) || 
                    $latestMessage->created_at > $userConversations[$userId]['message']->created_at) {
                    $userConversations[$userId] = [
                        'conversation' => $conversation,
                        'message' => $latestMessage,
                        'user' => $otherUser,
                        'unread_count' => $unreadCount
                    ];
                }
            }
        }
        
        // Convertir le tableau associatif en tableau indexé
        $result = array_values($userConversations);

        // Trier par date du dernier message (du plus récent au plus ancien)
        usort($result, function($a, $b) {
            return $b['message']->created_at <=> $a['message']->created_at;
        });

        return $result;
    }

    /**
     * Get or create a conversation with another user.
     */
    /**
     * Get the company profile associated with the user.
     */
    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    /**
     * Get the seller profile associated with the user.
     */
    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    /**
     * Check if the user is a company and has a completed profile.
     *
     * @return bool
     */
    public function hasCompletedCompanyProfile()
    {
        return $this->user_type === 'entreprise' && 
               $this->companyProfile && 
               $this->companyProfile->profile_completed;
    }

    /**
     * Check if the user is a seller and has a completed profile.
     *
     * @return bool
     */
    public function hasCompletedSellerProfile()
    {
        return $this->user_type === 'particulier' && 
               $this->is_seller && 
               $this->sellerProfile && 
               $this->sellerProfile->profile_completed;
    }

    /**
     * Check if the user can create a vehicle listing.
     * 
     * @return bool
     */
    public function canCreateVehicleListing()
    {
        // Si c'est une entreprise, elle doit avoir un profil complet
        if ($this->user_type === 'entreprise') {
            return $this->hasCompletedCompanyProfile();
        }
        
        // Si c'est un particulier vendeur, il doit avoir un profil complet
        if ($this->user_type === 'particulier' && $this->is_seller) {
            return $this->hasCompletedSellerProfile();
        }
        
        // Si c'est un particulier non vendeur, il ne peut pas créer d'annonce
        return false;
    }

    /**
     * Check if the user is a seller (either a company or a particular seller).
     *
     * @return bool
     */
    public function isSeller()
    {
        return $this->user_type === 'entreprise' || 
               ($this->user_type === 'particulier' && $this->is_seller);
    }

    public function getOrCreateConversationWith($userId, $vehicleId = null)
    {
        // 1. Vérifier d'abord s'il existe une conversation directe entre les deux utilisateurs
        $conversation = Conversation::where(function($query) use ($userId) {
                $query->where('user_one_id', $this->id)
                      ->where('user_two_id', $userId);
            })
            ->orWhere(function($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->where('user_two_id', $this->id);
            })
            ->first();
            
        // 2. Si aucune conversation directe n'existe, chercher une conversation où les deux utilisateurs ont échangé des messages
        if (!$conversation) {
            $myConversationIds = Message::where('user_id', $this->id)
                ->distinct()
                ->pluck('conversation_id');
                
            $otherUserConversationIds = Message::where('user_id', $userId)
                ->distinct()
                ->pluck('conversation_id');
                
            // Trouver les conversations communes
            $commonConversationIds = $myConversationIds->intersect($otherUserConversationIds);
            
            if ($commonConversationIds->count() > 0) {
                // Prendre la première conversation commune
                $conversation = Conversation::find($commonConversationIds->first());
            }
        }

        // 3. Si aucune conversation n'existe, en créer une nouvelle
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $this->id,
                'user_two_id' => $userId,
                'vehicle_id' => $vehicleId,
                'last_message_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Créer un premier message système pour établir la conversation
            $systemMessage = new Message();
            $systemMessage->conversation_id = $conversation->id;
            $systemMessage->user_id = $this->id;
            $systemMessage->content = "Conversation démarrée";
            $systemMessage->save();
            
            // Ajouter des logs pour déboguer
            \Log::info('Nouvelle conversation créée: ' . $conversation->id . ' entre ' . $this->id . ' et ' . $userId);
        }

        return $conversation;
    }
}
