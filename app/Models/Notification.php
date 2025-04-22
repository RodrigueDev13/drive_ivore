<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'read_at',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur associé à cette notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vérifier si la notification a été lue.
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }

    /**
     * Marquer la notification comme lue.
     */
    public function markAsRead()
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }

        return $this;
    }

    /**
     * Marquer la notification comme non lue.
     */
    public function markAsUnread()
    {
        if ($this->isRead()) {
            $this->update(['read_at' => null]);
        }

        return $this;
    }
}
