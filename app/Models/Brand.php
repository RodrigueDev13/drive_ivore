<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
    ];

    /**
     * Get the vehicles for the brand.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
    
    /**
     * Get the URL for the brand logo.
     */
    public function getLogoUrlAttribute()
    {
        if (empty($this->logo)) {
            return asset('images/placeholder.jpg');
        }
        
        if (str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }
        
        return asset('storage/' . $this->logo);
    }
}
