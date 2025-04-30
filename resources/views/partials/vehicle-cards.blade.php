@foreach($vehicles as $vehicle)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $vehicle->primaryImage) }}" alt="{{ $vehicle->brand->name }} {{ $vehicle->model }}" class="w-full h-full object-cover">
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">{{ $vehicle->brand->name }} {{ $vehicle->model }}</h3>
            <div class="flex justify-between mb-2">
                <span class="text-drive-teal font-bold">{{ $vehicle->formattedPrice }}</span>
                <span class="text-gray-600">{{ $vehicle->year }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-500 mb-2">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                    {{ number_format($vehicle->mileage, 0, ',', ' ') }} km
                </span>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    {{ $vehicle->city }}
                </span>
            </div>
            <div class="flex justify-between">
                <a href="{{ route('vehicles.show', $vehicle) }}" class="block text-center bg-drive-teal text-white py-2 px-4 rounded hover:bg-opacity-90 flex-grow mr-2">
                    Voir les détails
                </a>
                @auth
                    <button
                        class="favorite-button p-2 rounded-lg bg-red-50 hover:bg-red-100 border border-red-200 flex items-center justify-center"
                        data-vehicle-id="{{ $vehicle->id }}"
                        title="{{ Auth::user()->hasFavorited($vehicle) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ Auth::user()->hasFavorited($vehicle) ? 'text-red-500 fill-red-500' : 'text-gray-400' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                @else
                    <a href="{{ route('login') }}" class="p-2 rounded-lg bg-red-50 hover:bg-red-100 border border-red-200 flex items-center justify-center" title="Connectez-vous pour ajouter aux favoris">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const favoriteButtons = document.querySelectorAll('.favorite-button');

        favoriteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const vehicleId = this.dataset.vehicleId;
                const icon = this.querySelector('svg');

                fetch(`/favorites/${vehicleId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        icon.classList.add('text-red-500', 'fill-red-500');
                        icon.classList.remove('text-gray-400');
                        this.title = 'Retirer des favoris';
                    } else {
                        icon.classList.remove('text-red-500', 'fill-red-500');
                        icon.classList.add('text-gray-400');
                        this.title = 'Ajouter aux favoris';
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endpush
