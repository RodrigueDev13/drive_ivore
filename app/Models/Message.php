<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'conversation_id',
        'user_id',
        'content',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the conversation that owns the message.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the user who sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include unread messages.
     */
    public function scopeUnread($query)
    {
        // Vérifier si la colonne read_at existe dans la table
        if (\Schema::hasColumn('messages', 'read_at')) {
            return $query->whereNull('read_at');
        }
        
        // Si la colonne n'existe pas, retourner tous les messages (fallback)
        return $query;
    }

    /**
     * Mark the message as read.
     */
    public function markAsRead()
    {
        // Vérifier si la colonne read_at existe dans la table
        if (\Schema::hasColumn('messages', 'read_at')) {
            if (is_null($this->read_at)) {
                $this->update(['read_at' => now()]);
            }
        }
        // Si la colonne n'existe pas, ne rien faire
        return $this;
    }

    /**
     * Get all messages for a conversation.
     */
    public static function getConversationMessages($conversationId)
    {
        return self::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
