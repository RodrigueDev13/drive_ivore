<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'city',
        'description',
        'identity_document',
        'profile_completed'
    ];

    /**
     * Get the user that owns the seller profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the seller profile is complete.
     *
     * @return bool
     */
    public function isComplete()
    {
        return !empty($this->phone_number) &&
               !empty($this->address) &&
               !empty($this->city);
    }

    /**
     * Update the profile_completed status based on required fields.
     *
     * @return void
     */
    public function updateCompletionStatus()
    {
        $this->profile_completed = $this->isComplete();
        $this->save();
    }
}
