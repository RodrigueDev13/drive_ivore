<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'registration_number',
        'tax_id',
        'address',
        'city',
        'phone_number',
        'description',
        'logo',
        'website',
        'profile_completed'
    ];

    /**
     * Get the user that owns the company profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the company profile is complete.
     *
     * @return bool
     */
    public function isComplete()
    {
        return !empty($this->company_name) &&
               !empty($this->address) &&
               !empty($this->city) &&
               !empty($this->phone_number);
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
