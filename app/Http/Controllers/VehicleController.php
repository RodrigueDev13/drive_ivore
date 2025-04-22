<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleType;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Affiche la liste des véhicules.
     */
    public function index(Request $request)
    {
        $query = Vehicle::with(['brand', 'vehicleType', 'images']);

        // Filtres
        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('vehicle_type_id') && $request->vehicle_type_id) {
            $query->where('vehicle_type_id', $request->vehicle_type_id);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Tri
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $vehicles = $query->paginate(12);
        $brands = Brand::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();

        return view('vehicles.index', compact('vehicles', 'brands', 'vehicleTypes'));
    }

    /**
     * Affiche le formulaire de création d'un véhicule.
     */
    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();
        return view('vehicles.create', compact('brands', 'vehicleTypes'));
    }

    /**
     * Enregistre un nouveau véhicule.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|string|max:50',
            'transmission' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $vehicle = new Vehicle();
        $vehicle->title = $request->title;
        $vehicle->description = $request->description;
        $vehicle->price = $request->price;
        $vehicle->year = $request->year;
        $vehicle->mileage = $request->mileage;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->transmission = $request->transmission;
        $vehicle->location = $request->location;
        $vehicle->brand_id = $request->brand_id;
        $vehicle->vehicle_type_id = $request->vehicle_type_id;
        $vehicle->user_id = auth()->id();
        $vehicle->save();

        // Traitement des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');

                $vehicleImage = new VehicleImage();
                $vehicleImage->vehicle_id = $vehicle->id;
                $vehicleImage->path = $path;
                $vehicleImage->save();
            }
        }

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Véhicule ajouté avec succès !');
    }

    /**
     * Affiche les détails d'un véhicule.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['brand', 'vehicleType', 'images', 'user']);
        $isFavorite = auth()->check() ? auth()->user()->favorites->contains($vehicle->id) : false;

        // Véhicules similaires
        $similarVehicles = Vehicle::where('id', '!=', $vehicle->id)
            ->where(function($query) use ($vehicle) {
                $query->where('brand_id', $vehicle->brand_id)
                    ->orWhere('vehicle_type_id', $vehicle->vehicle_type_id);
            })
            ->with(['brand', 'vehicleType', 'images'])
            ->take(3)
            ->get();

        return view('vehicles.show', compact('vehicle', 'isFavorite', 'similarVehicles'));
    }

    /**
     * Affiche le formulaire d'édition d'un véhicule.
     */
    public function edit(Vehicle $vehicle)
    {
        // Vérifier que l'utilisateur est le propriétaire du véhicule
        if ($vehicle->user_id !== auth()->id()) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce véhicule.');
        }

        $brands = Brand::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();
        return view('vehicles.edit', compact('vehicle', 'brands', 'vehicleTypes'));
    }

    /**
     * Met à jour un véhicule.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        // Vérifier que l'utilisateur est le propriétaire du véhicule
        if ($vehicle->user_id !== auth()->id()) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce véhicule.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|string|max:50',
            'transmission' => 'required|string|max:50',
            'location' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
        ]);

        $vehicle->title = $request->title;
        $vehicle->description = $request->description;
        $vehicle->price = $request->price;
        $vehicle->year = $request->year;
        $vehicle->mileage = $request->mileage;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->transmission = $request->transmission;
        $vehicle->location = $request->location;
        $vehicle->brand_id = $request->brand_id;
        $vehicle->vehicle_type_id = $request->vehicle_type_id;
        $vehicle->save();

        // Supprimer les images sélectionnées
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = VehicleImage::find($imageId);
                if ($image && $image->vehicle_id == $vehicle->id) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // Ajouter de nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');

                $vehicleImage = new VehicleImage();
                $vehicleImage->vehicle_id = $vehicle->id;
                $vehicleImage->path = $path;
                $vehicleImage->save();
            }
        }

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Véhicule mis à jour avec succès !');
    }

    /**
     * Supprime un véhicule.
     */
    public function destroy(Vehicle $vehicle)
    {
        // Vérifier que l'utilisateur est le propriétaire du véhicule
        if ($vehicle->user_id !== auth()->id()) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce véhicule.');
        }

        // Supprimer les images
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Véhicule supprimé avec succès !');
    }
}
