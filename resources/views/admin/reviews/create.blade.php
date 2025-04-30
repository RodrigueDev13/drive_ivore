@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.reviews.index') }}" class="text-drive-teal hover:underline mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-drive-teal">Ajouter un avis</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.reviews.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Véhicule -->
                <div>
                    <label for="vehicle_id" class="block text-sm font-medium text-gray-700 mb-1">Véhicule</label>
                    <select name="vehicle_id" id="vehicle_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('vehicle_id') border-red-500 @enderror">
                        <option value="">Sélectionnez un véhicule</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->title }} ({{ $vehicle->brand->name }} - {{ $vehicle->year }})
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Note -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                    <div class="flex items-center">
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <label for="rating-{{ $i }}" class="cursor-pointer">
                                    <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" class="hidden" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 star-rating" viewBox="0 0 20 20" fill="currentColor"
                                        data-rating="{{ $i }}" onclick="setRating({{ $i }})">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        <span id="rating-text" class="ml-2 text-sm text-gray-500">Sélectionnez une note</span>
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commentaire -->
                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
                    <textarea name="comment" id="comment" rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.reviews.index') }}" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 transition mr-2">
                    Annuler
                </a>
                <button type="submit" class="bg-drive-teal text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition">
                    Créer l'avis
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les étoiles
        const stars = document.querySelectorAll('.star-rating');
        const ratingInput = document.querySelectorAll('input[name="rating"]');
        const ratingText = document.getElementById('rating-text');
        
        // Vérifier si une note est déjà sélectionnée
        const selectedRating = document.querySelector('input[name="rating"]:checked');
        if (selectedRating) {
            const rating = parseInt(selectedRating.value);
            updateStars(rating);
            updateRatingText(rating);
        }
        
        // Fonction pour mettre à jour l'apparence des étoiles
        function updateStars(rating) {
            stars.forEach(star => {
                const starRating = parseInt(star.dataset.rating);
                if (starRating <= rating) {
                    star.classList.add('text-yellow-400');
                    star.classList.remove('text-gray-300');
                } else {
                    star.classList.add('text-gray-300');
                    star.classList.remove('text-yellow-400');
                }
            });
        }
        
        // Fonction pour mettre à jour le texte de la note
        function updateRatingText(rating) {
            ratingText.textContent = `${rating} étoile${rating > 1 ? 's' : ''}`;
        }
        
        // Ajouter des écouteurs d'événements pour les étoiles
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                
                // Mettre à jour l'input radio
                ratingInput.forEach(input => {
                    if (parseInt(input.value) === rating) {
                        input.checked = true;
                    }
                });
                
                updateStars(rating);
                updateRatingText(rating);
            });
            
            // Effet de survol
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                updateStars(rating);
            });
            
            star.addEventListener('mouseleave', function() {
                const selectedRating = document.querySelector('input[name="rating"]:checked');
                if (selectedRating) {
                    updateStars(parseInt(selectedRating.value));
                } else {
                    updateStars(0);
                }
            });
        });
    });
    
    // Fonction globale pour définir la note
    function setRating(rating) {
        document.getElementById(`rating-${rating}`).checked = true;
    }
</script>
@endpush
@endsection
