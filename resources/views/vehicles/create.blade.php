@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('vehicles.index') }}" class="inline-flex items-center text-gray-600 hover:text-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Retour aux véhicules
        </a>
    </div>

    <h1 class="text-2xl font-bold mb-6">Ajouter un véhicule</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Erreur !</strong>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="listing_type" class="block text-sm font-medium text-gray-700 mb-1">Type d'annonce *</label>
                    <select name="listing_type" id="listing_type" required onchange="toggleRentalFields()"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <option value="vente" {{ old('listing_type') == 'vente' ? 'selected' : '' }}>Vente</option>
                        <option value="location" {{ old('listing_type') == 'location' ? 'selected' : '' }}>Location</option>
                        <option value="vente_location" {{ old('listing_type') == 'vente_location' ? 'selected' : '' }}>Vente et Location</option>
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix de vente (FCFA) <span id="price-required">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="1"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>
                
                <div id="rental-price-container" style="display: none;">
                    <label for="rental_price" class="block text-sm font-medium text-gray-700 mb-1">Prix de location (FCFA) <span id="rental-price-required"></span></label>
                    <input type="number" name="rental_price" id="rental_price" value="{{ old('rental_price') }}" min="0" step="1"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>
                
                <div id="rental-period-container" style="display: none;">
                    <label for="rental_period" class="block text-sm font-medium text-gray-700 mb-1">Période de location <span id="rental-period-required"></span></label>
                    <select name="rental_period" id="rental_period"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <option value="">Sélectionner une période</option>
                        <option value="jour" {{ old('rental_period') == 'jour' ? 'selected' : '' }}>Par jour</option>
                        <option value="semaine" {{ old('rental_period') == 'semaine' ? 'selected' : '' }}>Par semaine</option>
                        <option value="mois" {{ old('rental_period') == 'mois' ? 'selected' : '' }}>Par mois</option>
                    </select>
                </div>

                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Marque *</label>
                    <select name="brand_id" id="brand_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <option value="">Sélectionner une marque</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-1">Type de véhicule *</label>
                    <select name="vehicle_type_id" id="vehicle_type_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <option value="">Sélectionner un type</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type->id }}" {{ old('vehicle_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Année *</label>
                    <input type="number" name="year" id="year" value="{{ old('year') }}" required min="1900" max="{{ date('Y') + 1 }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="mileage" class="block text-sm font-medium text-gray-700 mb-1">Kilométrage *</label>
                    <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}" required min="0"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Carburant *</label>
                    <select name="fuel_type" id="fuel_type" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <option value="">Sélectionner un carburant</option>
                        <option value="Essence" {{ old('fuel_type') == 'Essence' ? 'selected' : '' }}>Essence</option>
                        <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Électrique" {{ old('fuel_type') == 'Électrique' ? 'selected' : '' }}>Électrique</option>
                        <option value="Hybride" {{ old('fuel_type') == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                        <option value="GPL" {{ old('fuel_type') == 'GPL' ? 'selected' : '' }}>GPL</option>
                    </select>
                </div>

                <div>
                    <label for="transmission" class="block text-sm font-medium text-gray-700 mb-1">Transmission *</label>
                    <select name="transmission" id="transmission" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <option value="">Sélectionner une transmission</option>
                        <option value="Manuelle" {{ old('transmission') == 'Manuelle' ? 'selected' : '' }}>Manuelle</option>
                        <option value="Automatique" {{ old('transmission') == 'Automatique' ? 'selected' : '' }}>Automatique</option>
                        <option value="Semi-automatique" {{ old('transmission') == 'Semi-automatique' ? 'selected' : '' }}>Semi-automatique</option>
                    </select>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Localisation *</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>
                
                <div class="md:col-span-2">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Couleur *</label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                <textarea name="description" id="description" rows="5" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Images</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                                <span>Télécharger des fichiers</span>
                                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*" onchange="previewImages(this)">
                            </label>
                            <p class="pl-1">ou glisser-déposer</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                    </div>
                </div>
                
                <!-- Prévisualisation des images -->
                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md hover:bg-teal-600 transition">
                    Ajouter le véhicule
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImages(input) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        
        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-32 object-cover rounded-md';
                    div.appendChild(img);
                    
                    const filename = document.createElement('p');
                    filename.className = 'text-xs text-gray-500 mt-1 truncate';
                    filename.textContent = file.name;
                    div.appendChild(filename);
                    
                    preview.appendChild(div);
                }
                
                reader.readAsDataURL(file);
            });
        }
    }
    
    function toggleRentalFields() {
        const listingType = document.getElementById('listing_type').value;
        const rentalPriceContainer = document.getElementById('rental-price-container');
        const rentalPeriodContainer = document.getElementById('rental-period-container');
        const rentalPriceRequired = document.getElementById('rental-price-required');
        const rentalPeriodRequired = document.getElementById('rental-period-required');
        const priceRequired = document.getElementById('price-required');
        const priceInput = document.getElementById('price');
        const rentalPriceInput = document.getElementById('rental_price');
        const rentalPeriodInput = document.getElementById('rental_period');
        
        // Réinitialiser tous les champs
        rentalPriceContainer.style.display = 'none';
        rentalPeriodContainer.style.display = 'none';
        rentalPriceRequired.textContent = '';
        rentalPeriodRequired.textContent = '';
        priceRequired.textContent = '*';
        priceInput.required = true;
        rentalPriceInput.required = false;
        rentalPeriodInput.required = false;
        
        if (listingType === 'location') {
            // Si c'est une location, afficher les champs de location et masquer le prix de vente
            rentalPriceContainer.style.display = 'block';
            rentalPeriodContainer.style.display = 'block';
            rentalPriceRequired.textContent = '*';
            rentalPeriodRequired.textContent = '*';
            priceRequired.textContent = '';
            priceInput.required = false;
            rentalPriceInput.required = true;
            rentalPeriodInput.required = true;
        } else if (listingType === 'vente_location') {
            // Si c'est vente et location, afficher tous les champs
            rentalPriceContainer.style.display = 'block';
            rentalPeriodContainer.style.display = 'block';
            rentalPriceRequired.textContent = '*';
            rentalPeriodRequired.textContent = '*';
            priceRequired.textContent = '*';
            priceInput.required = true;
            rentalPriceInput.required = true;
            rentalPeriodInput.required = true;
        }
    }
    
    // Exécuter au chargement de la page pour initialiser l'état des champs
    document.addEventListener('DOMContentLoaded', function() {
        toggleRentalFields();
    });
</script>
@endsection
