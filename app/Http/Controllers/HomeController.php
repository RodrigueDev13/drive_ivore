<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil.
     */
    public function index()
    {
        // Récupérer les véhicules mis en avant
        $featuredVehicles = Vehicle::where('is_featured', true)
            ->with(['brand', 'vehicleType', 'images'])
            ->take(6)
            ->get();

        // Récupérer les véhicules récents
        $recentVehicles = Vehicle::where('is_sold', false)
            ->with(['brand', 'vehicleType', 'images'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Récupérer les marques populaires
        $brands = Brand::withCount('vehicles')
            ->orderBy('vehicles_count', 'desc')
            ->take(8)
            ->get();

        // Récupérer les types de véhicules
        $vehicleTypes = VehicleType::withCount('vehicles')
            ->orderBy('vehicles_count', 'desc')
            ->get();

        return view('home', compact('featuredVehicles', 'recentVehicles', 'brands', 'vehicleTypes'));
    }
}
