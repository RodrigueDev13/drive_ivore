<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AdminVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $vehicles = Vehicle::with(['brand', 'vehicleType', 'user', 'images'])
            ->latest()
            ->paginate(10);
        
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $brands = Brand::all();
        $vehicleTypes = VehicleType::all();
        
        return view('admin.vehicles.create', compact('brands', 'vehicleTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'fuel_type' => 'required|string|in:essence,diesel,hybride,électrique',
            'transmission' => 'required|string|in:manuelle,automatique',
            'color' => 'required|string|max:50',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
        ]);

        $vehicle = Vehicle::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'brand_id' => $request->brand_id,
            'vehicle_type_id' => $request->vehicle_type_id,
            'fuel_type' => $request->fuel_type,
            'transmission' => $request->transmission,
            'color' => $request->color,
            'user_id' => auth()->id(),
            'is_featured' => $request->has('is_featured'),
            'status' => 'available',
        ]);

        // Traitement des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $vehicle->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $vehicle = Vehicle::with(['brand', 'vehicleType', 'user', 'images'])
            ->findOrFail($id);
        
        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $vehicle = Vehicle::findOrFail($id);
        $brands = Brand::all();
        $vehicleTypes = VehicleType::all();
        
        return view('admin.vehicles.edit', compact('vehicle', 'brands', 'vehicleTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $vehicle = Vehicle::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'listing_type' => 'required|string|in:sale,rent,both',
            'rental_price' => 'nullable|numeric|min:0|required_if:listing_type,rent,both',
            'rental_period' => 'nullable|string|in:day,week,month|required_if:listing_type,rent,both',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'fuel_type' => 'required|string|in:essence,diesel,hybride,électrique',
            'transmission' => 'required|string|in:manuelle,automatique',
            'color' => 'required|string|max:50',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'nullable|string|in:available,sold,reserved',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'listing_type' => $request->listing_type,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'brand_id' => $request->brand_id,
            'vehicle_type_id' => $request->vehicle_type_id,
            'fuel_type' => $request->fuel_type,
            'transmission' => $request->transmission,
            'color' => $request->color,
            'is_featured' => $request->has('is_featured'),
        ];
        
        // Ajouter les champs de location si nécessaire
        if ($request->listing_type == 'rent' || $request->listing_type == 'both') {
            $updateData['rental_price'] = $request->rental_price;
            $updateData['rental_period'] = $request->rental_period;
        }
        
        // Ajouter le statut s'il est présent
        if ($request->has('status')) {
            $updateData['status'] = $request->status;
        }
        
        $vehicle->update($updateData);

        // Traitement des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $vehicle->images()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $vehicle = Vehicle::findOrFail($id);
        
        // Supprimer les images associées
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule supprimé avec succès');
    }
    
    /**
     * Remove an image from a vehicle.
     */
    public function deleteImage(string $vehicleId, string $imageId): RedirectResponse
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        $image = $vehicle->images()->findOrFail($imageId);
        
        Storage::disk('public')->delete($image->path);
        $image->delete();
        
        return redirect()->route('admin.vehicles.edit', $vehicle->id)
            ->with('success', 'Image supprimée avec succès');
    }
    
    /**
     * Toggle the featured status of a vehicle.
     */
    public function toggleFeatured(string $id): RedirectResponse
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->is_featured = !$vehicle->is_featured;
        $vehicle->save();
        
        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Statut "En vedette" modifié avec succès');
    }
}
