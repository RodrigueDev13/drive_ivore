<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'brand_id',
        'vehicle_type_id',
        'model',
        'year',
        'mileage',
        'price',
        'rental_price',
        'rental_period',
        'listing_type',
        'description',
        'city',
        'is_sold',
        'is_featured',
        'views',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_sold' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Obtenir l'utilisateur propriétaire du véhicule.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir la marque du véhicule.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Obtenir le type du véhicule.
     */
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Obtenir les images du véhicule.
     */
    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    /**
     * Obtenir les utilisateurs qui ont mis ce véhicule en favori.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * Obtenir les conversations liées à ce véhicule.
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Obtenir les avis sur ce véhicule.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Obtenir l'image principale du véhicule.
     */
    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->images()->where('is_primary', true)->first();

        if (!$primaryImage) {
            $primaryImage = $this->images()->first();
        }

        return $primaryImage ? $primaryImage->path : 'images/vehicles/default.jpg';
    }

    /**
     * Obtenir l'URL de l'image principale.
     */
    public function getPrimaryImageUrlAttribute()
    {
        $primaryImage = $this->images()->where('is_primary', true)->first();

        if (!$primaryImage) {
            $primaryImage = $this->images()->first();
        }

        if ($primaryImage) {
            return $primaryImage->url;
        }

        return asset('images/vehicles/default.jpg');
    }

    /**
     * Obtenir le prix formaté.
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Obtenir la note moyenne des avis.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    /**
     * Incrémenter le compteur de vues.
     */
    public function incrementViews()
    {
        $this->increment('views');
        return $this;
    }

    /**
     * Marquer le véhicule comme vendu.
     */
    public function markAsSold()
    {
        $this->update(['is_sold' => true]);
        return $this;
    }

    /**
     * Marquer le véhicule comme disponible.
     */
    public function markAsAvailable()
    {
        $this->update(['is_sold' => false]);
        return $this;
    }

    /**
     * Marquer le véhicule comme mis en avant.
     */
    public function markAsFeatured()
    {
        $this->update(['is_featured' => true]);
        return $this;
    }

    /**
     * Retirer le véhicule des mises en avant.
     */
    public function unmarkAsFeatured()
    {
        $this->update(['is_featured' => false]);
        return $this;
    }
}
