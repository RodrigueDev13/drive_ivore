<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord d'administration
     */
    public function index(): View
    {
        // Récupérer les statistiques pour le tableau de bord
        $stats = [
            'users' => User::count(),
            'vehicles' => Vehicle::count(),
            'brands' => Brand::count(),
            'vehicleTypes' => VehicleType::count(),
        ];

        return view('admin.index', compact('stats'));
    }

    /**
     * Affiche les statistiques du site
     */
    public function statistics(): View
    {
        // Statistiques plus détaillées
        $userStats = User::selectRaw('COUNT(*) as total, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        $vehicleStats = Vehicle::selectRaw('COUNT(*) as total, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        return view('admin.statistics', compact('userStats', 'vehicleStats'));
    }

    /**
     * Affiche les paramètres du site
     */
    public function settings(): View
    {
        return view('admin.settings');
    }

    /**
     * Met à jour les paramètres du site
     */
    public function updateSettings(Request $request)
    {
        // Logique pour mettre à jour les paramètres
        return redirect()->route('admin.settings')->with('success', 'Paramètres mis à jour avec succès');
    }
}
