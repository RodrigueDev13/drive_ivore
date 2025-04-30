@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.vehicles.index') }}" class="text-drive-teal hover:underline mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-drive-teal">Modifier le véhicule</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $vehicle->title) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Marque -->
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                    <select name="brand_id" id="brand_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('brand_id') border-red-500 @enderror">
                        <option value="">Sélectionner une marque</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $vehicle->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type de véhicule -->
                <div>
                    <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-1">Type de véhicule</label>
                    <select name="vehicle_type_id" id="vehicle_type_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('vehicle_type_id') border-red-500 @enderror">
                        <option value="">Sélectionner un type</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type->id }}" {{ old('vehicle_type_id', $vehicle->vehicle_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('vehicle_type_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prix -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix de vente (FCFA)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $vehicle->price) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type d'annonce -->
                <div>
                    <label for="listing_type" class="block text-sm font-medium text-gray-700 mb-1">Type d'annonce</label>
                    <select name="listing_type" id="listing_type" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('listing_type') border-red-500 @enderror"
                        onchange="toggleRentalFields()">
                        <option value="sale" {{ old('listing_type', $vehicle->listing_type) == 'sale' ? 'selected' : '' }}>Vente</option>
                        <option value="rent" {{ old('listing_type', $vehicle->listing_type) == 'rent' ? 'selected' : '' }}>Location</option>
                        <option value="both" {{ old('listing_type', $vehicle->listing_type) == 'both' ? 'selected' : '' }}>Vente et Location</option>
                    </select>
                    @error('listing_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prix de location (visible uniquement si location ou les deux) -->
                <div id="rental-fields" class="space-y-4" style="display: none;">
                    <div>
                        <label for="rental_price" class="block text-sm font-medium text-gray-700 mb-1">Prix de location (FCFA)</label>
                        <input type="number" name="rental_price" id="rental_price" value="{{ old('rental_price', $vehicle->rental_price) }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('rental_price') border-red-500 @enderror">
                        @error('rental_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rental_period" class="block text-sm font-medium text-gray-700 mb-1">Période de location</label>
                        <select name="rental_period" id="rental_period" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('rental_period') border-red-500 @enderror">
                            <option value="day" {{ old('rental_period', $vehicle->rental_period) == 'day' ? 'selected' : '' }}>Par jour</option>
                            <option value="week" {{ old('rental_period', $vehicle->rental_period) == 'week' ? 'selected' : '' }}>Par semaine</option>
                            <option value="month" {{ old('rental_period', $vehicle->rental_period) == 'month' ? 'selected' : '' }}>Par mois</option>
                        </select>
                        @error('rental_period')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Année -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                    <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" min="1900" max="{{ date('Y') + 1 }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('year') border-red-500 @enderror">
                    @error('year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kilométrage -->
                <div>
                    <label for="mileage" class="block text-sm font-medium text-gray-700 mb-1">Kilométrage (km)</label>
                    <input type="number" name="mileage" id="mileage" value="{{ old('mileage', $vehicle->mileage) }}" min="0" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('mileage') border-red-500 @enderror">
                    @error('mileage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Carburant -->
                <div>
                    <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Type de carburant</label>
                    <select name="fuel_type" id="fuel_type" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('fuel_type') border-red-500 @enderror">
                        <option value="essence" {{ old('fuel_type', $vehicle->fuel_type) == 'essence' ? 'selected' : '' }}>Essence</option>
                        <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="hybride" {{ old('fuel_type', $vehicle->fuel_type) == 'hybride' ? 'selected' : '' }}>Hybride</option>
                        <option value="électrique" {{ old('fuel_type', $vehicle->fuel_type) == 'électrique' ? 'selected' : '' }}>Électrique</option>
                    </select>
                    @error('fuel_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transmission -->
                <div>
                    <label for="transmission" class="block text-sm font-medium text-gray-700 mb-1">Transmission</label>
                    <select name="transmission" id="transmission" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('transmission') border-red-500 @enderror">
                        <option value="manuelle" {{ old('transmission', $vehicle->transmission) == 'manuelle' ? 'selected' : '' }}>Manuelle</option>
                        <option value="automatique" {{ old('transmission', $vehicle->transmission) == 'automatique' ? 'selected' : '' }}>Automatique</option>
                    </select>
                    @error('transmission')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Couleur -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $vehicle->color) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('color') border-red-500 @enderror">
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mise en vedette -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $vehicle->is_featured) ? 'checked' : '' }} 
                            class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-700">Mettre en vedette</label>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Les véhicules en vedette sont affichés en priorité sur la page d'accueil.</p>
                </div>

                <!-- Statut -->
                <div class="md:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" id="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('status') border-red-500 @enderror">
                        <option value="available" {{ old('status', $vehicle->status) == 'available' ? 'selected' : '' }}>Disponible</option>
                        <option value="reserved" {{ old('status', $vehicle->status) == 'reserved' ? 'selected' : '' }}>Réservé</option>
                        <option value="sold" {{ old('status', $vehicle->status) == 'sold' ? 'selected' : '' }}>Vendu</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Images actuelles -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Images actuelles</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @forelse($vehicle->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $vehicle->title }}" class="h-32 w-full object-cover rounded-lg">
                                <form action="{{ route('admin.vehicles.delete-image', [$vehicle->id, $image->id]) }}" method="POST" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 focus:outline-none" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="md:col-span-4 p-4 bg-gray-100 rounded-lg text-center text-gray-500">
                                Aucune image disponible pour ce véhicule
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Nouvelles images -->
                <div class="md:col-span-2">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Ajouter de nouvelles images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror">
                    <p class="text-gray-500 text-xs mt-1">Vous pouvez sélectionner plusieurs images. Formats acceptés : JPG, PNG, GIF. Taille maximale : 2 Mo par image.</p>
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="6" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('description') border-red-500 @enderror">{{ old('description', $vehicle->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 transition mr-2">
                    Annuler
                </a>
                <button type="submit" class="bg-drive-teal text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition">
                    Mettre à jour le véhicule
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleRentalFields() {
        const listingType = document.getElementById('listing_type').value;
        const rentalFields = document.getElementById('rental-fields');
        
        if (listingType === 'rent' || listingType === 'both') {
            rentalFields.style.display = 'block';
        } else {
            rentalFields.style.display = 'none';
        }
    }
    
    // Exécuter au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        toggleRentalFields();
    });
</script>
@endpush
