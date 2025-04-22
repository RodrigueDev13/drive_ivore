<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Affiche la liste des véhicules favoris de l'utilisateur.
     */
    public function index()
    {
        $favorites = auth()->user()->favorites()->with(['brand', 'vehicleType', 'images'])->get();
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Ajoute un véhicule aux favoris.
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        auth()->user()->favorites()->attach($vehicle->id);
        return redirect()->back()->with('success', 'Véhicule ajouté aux favoris !');
    }

    /**
     * Supprime un véhicule des favoris.
     */
    public function destroy(Vehicle $vehicle)
    {
        auth()->user()->favorites()->detach($vehicle->id);
        return redirect()->back()->with('success', 'Véhicule retiré des favoris !');
    }
}
