<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    /**
     * Afficher tous les types de véhicules.
     */
    public function index()
    {
        $vehicleTypes = VehicleType::withCount('vehicles')->orderBy('name')->get();
        return view('vehicle-types.index', compact('vehicleTypes'));
    }
}
