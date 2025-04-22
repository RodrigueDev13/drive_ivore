<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'rating',
        'comment',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Obtenir l'utilisateur qui a laissé cet avis.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le véhicule concerné par cet avis.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
