<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle_id',
        'path',
        'is_primary',
        'order',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Obtenir le véhicule associé à cette image.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Obtenir l'URL complète de l'image.
     */
    public function getUrlAttribute()
    {
        if (str_starts_with($this->path, 'http')) {
            return $this->path;
        }

        return asset('storage/' . $this->path);
    }

    /**
     * Définir cette image comme image principale.
     */
    public function setPrimary()
    {
        // Réinitialiser toutes les images du véhicule
        $this->vehicle->images()->update(['is_primary' => false]);

        // Définir cette image comme principale
        $this->update(['is_primary' => true]);

        return $this;
    }
}
