<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
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
        'icon',
    ];

    /**
     * Get the vehicles for the vehicle type.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
    
    /**
     * Get the URL for the vehicle type icon.
     */
    public function getIconUrlAttribute()
    {
        if (empty($this->icon)) {
            return asset('images/placeholder.jpg');
        }
        
        if (str_starts_with($this->icon, 'http')) {
            return $this->icon;
        }
        
        return asset('storage/' . $this->icon);
    }
}
