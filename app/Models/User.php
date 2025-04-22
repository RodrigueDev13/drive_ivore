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
        return Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id)
            ->orderBy('last_message_at', 'desc')
            ->get();
    }

    /**
     * Get the latest messages for each conversation the user is part of.
     */
    public function getLatestMessages()
    {
        $conversations = $this->conversations();
        $result = [];

        foreach ($conversations as $conversation) {
            $latestMessage = Message::where('conversation_id', $conversation->id)
                ->latest()
                ->first();

            if ($latestMessage) {
                $otherUser = $conversation->getOtherUser($this->id);

                $result[] = [
                    'conversation' => $conversation,
                    'message' => $latestMessage,
                    'user' => $otherUser
                ];
            }
        }

        // Trier par date du dernier message (du plus récent au plus ancien)
        usort($result, function($a, $b) {
            return $b['message']->created_at <=> $a['message']->created_at;
        });

        return $result;
    }

    /**
     * Get or create a conversation with another user.
     */
    public function getOrCreateConversationWith($userId, $vehicleId = null)
    {
        // Chercher une conversation existante
        $conversation = Conversation::where(function($query) use ($userId) {
                $query->where('user_one_id', $this->id)
                      ->where('user_two_id', $userId);
            })
            ->orWhere(function($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->where('user_two_id', $this->id);
            })
            ->first();

        // Si aucune conversation n'existe, en créer une nouvelle
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $this->id,
                'user_two_id' => $userId,
                'vehicle_id' => $vehicleId,
                'last_message_at' => now(),
            ]);
        }

        return $conversation;
    }
}
