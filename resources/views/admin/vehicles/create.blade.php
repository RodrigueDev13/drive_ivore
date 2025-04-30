@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.vehicles.index') }}" class="inline-flex items-center text-gray-600 hover:text-drive-teal">
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
        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="listing_type" class="block text-sm font-medium text-gray-700 mb-1">Type d'annonce *</label>
                    <select name="listing_type" id="listing_type" required onchange="toggleRentalFields()"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                        <option value="vente" {{ old('listing_type') == 'vente' ? 'selected' : '' }}>Vente</option>
                        <option value="location" {{ old('listing_type') == 'location' ? 'selected' : '' }}>Location</option>
                        <option value="vente_location" {{ old('listing_type') == 'vente_location' ? 'selected' : '' }}>Vente et Location</option>
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix de vente (FCFA) <span id="price-required">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="1"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                </div>

                <div id="rental-price-container" style="display: none;">
                    <label for="rental_price" class="block text-sm font-medium text-gray-700 mb-1">Prix de location (FCFA) <span id="rental-price-required">*</span></label>
                    <input type="number" name="rental_price" id="rental_price" value="{{ old('rental_price') }}" min="0" step="1"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                </div>

                <div id="rental-period-container" style="display: none;">
                    <label for="rental_period" class="block text-sm font-medium text-gray-700 mb-1">Période de location <span id="rental-period-required">*</span></label>
                    <select name="rental_period" id="rental_period"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                        <option value="jour" {{ old('rental_period') == 'jour' ? 'selected' : '' }}>Par jour</option>
                        <option value="semaine" {{ old('rental_period') == 'semaine' ? 'selected' : '' }}>Par semaine</option>
                        <option value="mois" {{ old('rental_period') == 'mois' ? 'selected' : '' }}>Par mois</option>
                    </select>
                </div>

                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Marque *</label>
                    <select name="brand_id" id="brand_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                        <option value="">Sélectionner une marque</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-1">Type de véhicule *</label>
                    <select name="vehicle_type_id" id="vehicle_type_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                        <option value="">Sélectionner un type</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type->id }}" {{ old('vehicle_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="mileage" class="block text-sm font-medium text-gray-700 mb-1">Kilométrage *</label>
                    <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}" required min="0"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Année *</label>
                    <input type="number" name="year" id="year" value="{{ old('year') }}" required min="1900" max="{{ date('Y') + 1 }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Carburant *</label>
                    <select name="fuel_type" id="fuel_type" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                        <option value="Essence" {{ old('fuel_type') == 'Essence' ? 'selected' : '' }}>Essence</option>
                        <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Hybride" {{ old('fuel_type') == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                        <option value="Électrique" {{ old('fuel_type') == 'Électrique' ? 'selected' : '' }}>Électrique</option>
                        <option value="GPL" {{ old('fuel_type') == 'GPL' ? 'selected' : '' }}>GPL</option>
                    </select>
                </div>

                <div>
                    <label for="transmission" class="block text-sm font-medium text-gray-700 mb-1">Transmission *</label>
                    <select name="transmission" id="transmission" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                        <option value="Manuelle" {{ old('transmission') == 'Manuelle' ? 'selected' : '' }}>Manuelle</option>
                        <option value="Automatique" {{ old('transmission') == 'Automatique' ? 'selected' : '' }}>Automatique</option>
                    </select>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Localisation *</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                </div>

                <div class="md:col-span-2">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Couleur *</label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">
                </div>

            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                <textarea name="description" id="description" rows="5" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Images</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal-200 focus:ring-opacity-50" onchange="previewImages(this)">
                <p class="text-gray-500 text-xs mt-1">Vous pouvez sélectionner plusieurs images. Formats acceptés: JPG, PNG, GIF.</p>
                
                <!-- Prévisualisation des images -->
                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} 
                        class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700">Mettre en vedette</label>
                </div>
                <p class="text-gray-500 text-xs mt-1">Les véhicules en vedette sont affichés en priorité sur la page d'accueil.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-drive-teal text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition">
                    Ajouter le véhicule
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
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
        
        if (rentalPriceRequired) rentalPriceRequired.textContent = '';
        if (rentalPeriodRequired) rentalPeriodRequired.textContent = '';
        if (priceRequired) priceRequired.textContent = '*';
        
        if (priceInput) priceInput.required = true;
        if (rentalPriceInput) rentalPriceInput.required = false;
        if (rentalPeriodInput) rentalPeriodInput.required = false;
        
        if (listingType === 'location') {
            // Si c'est une location, afficher les champs de location et masquer le prix de vente
            rentalPriceContainer.style.display = 'block';
            rentalPeriodContainer.style.display = 'block';
            
            if (rentalPriceRequired) rentalPriceRequired.textContent = '*';
            if (rentalPeriodRequired) rentalPeriodRequired.textContent = '*';
            if (priceRequired) priceRequired.textContent = '';
            
            if (priceInput) priceInput.required = false;
            if (rentalPriceInput) rentalPriceInput.required = true;
            if (rentalPeriodInput) rentalPeriodInput.required = true;
        } else if (listingType === 'vente_location') {
            // Si c'est vente et location, afficher tous les champs
            rentalPriceContainer.style.display = 'block';
            rentalPeriodContainer.style.display = 'block';
            
            if (rentalPriceRequired) rentalPriceRequired.textContent = '*';
            if (rentalPeriodRequired) rentalPeriodRequired.textContent = '*';
            if (priceRequired) priceRequired.textContent = '*';
            
            if (priceInput) priceInput.required = true;
            if (rentalPriceInput) rentalPriceInput.required = true;
            if (rentalPeriodInput) rentalPeriodInput.required = true;
        }
    }
    
    // Exécuter au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        toggleRentalFields();
    });
</script>
@endpush
