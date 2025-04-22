<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Affiche la page de recherche.
     */
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();

        $query = Vehicle::with(['brand', 'vehicleType', 'images'])
            ->where('active', true);

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('vehicle_type_id')) {
            $query->where('vehicle_type_id', $request->vehicle_type_id);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        $vehicles = $query->latest()->paginate(12);

        return view('search', compact('vehicles', 'brands', 'vehicleTypes'));
    }
}
