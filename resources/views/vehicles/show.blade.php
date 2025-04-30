@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <!-- Images du véhicule -->
            <div>
                @if($vehicle->images->count() > 0)
                    <div class="mb-4 relative h-64 md:h-96 rounded-lg overflow-hidden">
                        <img id="mainImage" src="{{ asset('storage/' . $vehicle->images->first()->path) }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover">
                    </div>

                    @if($vehicle->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($vehicle->images as $image)
                                <div class="h-20 rounded-lg overflow-hidden cursor-pointer hover:opacity-80 transition" onclick="changeMainImage('{{ asset('storage/' . $image->path) }}')">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="h-64 md:h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Informations du véhicule -->
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $vehicle->title }}</h1>

                <div class="flex items-center text-gray-600 mb-4">
                    <span class="mr-4">{{ $vehicle->brand->name }}</span>
                    <span class="mr-4">{{ $vehicle->year }}</span>
                    <span>{{ number_format($vehicle->mileage, 0, ',', ' ') }} km</span>
                </div>

                <div class="text-3xl font-bold text-teal-600 mb-6">
                    {{ number_format($vehicle->price, 0, ',', ' ') }} FCFA
                </div>

                <div class="flex flex-col space-y-4">
                    <!-- Type d'annonce -->
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600 font-medium">
                            @if($vehicle->listing_type == 'vente')
                                Vente
                            @elseif($vehicle->listing_type == 'location')
                                Location
                            @elseif($vehicle->listing_type == 'vente_location')
                                Vente et Location
                            @else
                                Vente
                            @endif
                        </span>
                    </div>
                    
                    <!-- Année -->
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V5z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600">{{ $vehicle->year }}</span>
                    </div>
                    
                    <!-- Kilométrage -->
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1h3a1 1 0 00.8-.4l3-4a1 1 0 00.2-.6V8a1 1 0 00-1-1h-3.05A2.5 2.5 0 0010 5.05V5a1 1 0 00-1-1H3z" />
                        </svg>
                        <span class="text-gray-600">{{ number_format($vehicle->mileage, 0, ',', ' ') }} km</span>
                    </div>
                    
                    <!-- Transmission -->
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600">{{ $vehicle->transmission }}</span>
                    </div>
                    
                    <!-- Carburant -->
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600">{{ $vehicle->fuel_type }}</span>
                    </div>
                    
                    <!-- Localisation -->
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600">{{ $vehicle->location }}</span>
                    </div>
                    
                    <!-- Couleur -->
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-600">{{ $vehicle->color }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Type</div>
                        <div class="font-medium">{{ $vehicle->vehicleType->name }}</div>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Transmission</div>
                        <div class="font-medium">{{ $vehicle->transmission }}</div>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Carburant</div>
                        <div class="font-medium">{{ $vehicle->fuel_type }}</div>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Couleur</div>
                        <div class="font-medium">{{ $vehicle->color ?? 'Non spécifiée' }}</div>
                    </div>
                    
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Localisation</div>
                        <div class="font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            {{ $vehicle->location ?? $vehicle->city ?? 'Non spécifiée' }}
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 mb-6">
                    <a href="{{ route('messages.create', ['vehicle_id' => $vehicle->id]) }}" class="flex-1 bg-teal-500 text-white py-3 px-4 rounded-lg text-center hover:bg-teal-600 transition flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                        Contacter le vendeur
                    </a>

                    @auth
                        @if($isFavorite)
                            <form action="{{ route('favorites.destroy', $vehicle->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-300 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-500">
                                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('favorites.store', $vehicle->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-300 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h2 class="text-xl font-bold mb-3">Informations sur le vendeur</h2>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium">{{ $vehicle->user->name }}</div>
                            <div class="text-sm text-gray-500">Membre depuis {{ $vehicle->user->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-gray-200">
            <h2 class="text-xl font-bold mb-4">Description</h2>
            <div class="prose max-w-none">
                {!! nl2br(e($vehicle->description)) !!}
            </div>
        </div>
    </div>

    @if($vehicle->listing_type == 'vente' || $vehicle->listing_type == 'vente_location')
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800">Prix de vente: {{ $vehicle->formatted_price }}</h2>
        </div>
    @endif
    
    @if($vehicle->listing_type == 'location' || $vehicle->listing_type == 'vente_location')
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Prix de location: {{ number_format($vehicle->rental_price, 0, ',', ' ') }} FCFA
                @if($vehicle->rental_period == 'jour')
                    / jour
                @elseif($vehicle->rental_period == 'semaine')
                    / semaine
                @elseif($vehicle->rental_period == 'mois')
                    / mois
                @endif
            </h2>
        </div>
    @endif

    @if($similarVehicles->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Véhicules similaires</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarVehicles as $similarVehicle)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative h-48">
                            @if($similarVehicle->images->count() > 0)
                                <img src="{{ asset('storage/' . $similarVehicle->images->first()->path) }}" alt="{{ $similarVehicle->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-md text-sm font-bold">
                                {{ number_format($similarVehicle->price, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-1">{{ $similarVehicle->title }}</h3>
                            <div class="text-sm text-gray-600 mb-2">
                                {{ $similarVehicle->brand->name }} | {{ $similarVehicle->year }} | {{ $similarVehicle->mileage }} km
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">{{ $similarVehicle->created_at->diffForHumans() }}</span>
                                <a href="{{ route('vehicles.show', $similarVehicle) }}" class="text-teal-500 hover:text-teal-700">Voir détails</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;
    }
</script>
@endsection
