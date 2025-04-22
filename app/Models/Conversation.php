<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'vehicle_id',
        'last_message_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the first user in the conversation.
     */
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * Get the second user in the conversation.
     */
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Get the vehicle associated with the conversation.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the messages in this conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the latest message in this conversation.
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Get the other user in the conversation (relative to the given user).
     */
    public function getOtherUser($userId)
    {
        if ($this->user_one_id == $userId) {
            return $this->userTwo;
        } else {
            return $this->userOne;
        }
    }
}
