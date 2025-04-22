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
            <div class="flex justify-between text-sm text-gray-500 mb-4">
                <span>{{ number_format($vehicle->mileage, 0, ',', ' ') }} km</span>
                <span>{{ $vehicle->city }}</span>
            </div>
            <div class="flex justify-between">
                <a href="{{ route('vehicles.show', $vehicle) }}" class="block text-center bg-drive-teal text-white py-2 px-4 rounded hover:bg-opacity-90">
                    Voir les détails
                </a>
                @auth
                    <button
                        class="favorite-button p-2 rounded-full hover:bg-gray-100"
                        data-vehicle-id="{{ $vehicle->id }}"
                        title="{{ Auth::user()->hasFavorited($vehicle) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ Auth::user()->hasFavorited($vehicle) ? 'text-red-500 fill-red-500' : 'text-gray-400' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682  stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
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
