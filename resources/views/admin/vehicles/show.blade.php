@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.vehicles.index') }}" class="text-drive-teal hover:underline mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-drive-teal">Détails du véhicule</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $vehicle->title }}</h2>
                    <p class="text-gray-600 mt-1">{{ $vehicle->brand->name }} - {{ $vehicle->year }}</p>
                    <div class="mt-2 flex space-x-2">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($vehicle->status == 'available') bg-green-100 text-green-800 
                            @elseif($vehicle->status == 'sold') bg-red-100 text-red-800 
                            @else bg-yellow-100 text-yellow-800 @endif">
                            @if($vehicle->status == 'available') Disponible 
                            @elseif($vehicle->status == 'sold') Vendu 
                            @else Réservé @endif
                        </span>
                        @if($vehicle->is_featured)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                En vedette
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                    <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Images du véhicule -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Images</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse($vehicle->images as $image)
                        <div class="relative h-40 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $vehicle->title }}" class="h-full w-full object-cover">
                        </div>
                    @empty
                        <div class="col-span-4 bg-gray-100 rounded-lg p-4 text-center text-gray-500">
                            Aucune image disponible pour ce véhicule
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Informations du véhicule -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations du véhicule</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Marque</p>
                        <p class="font-medium">{{ $vehicle->brand->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Type de véhicule</p>
                        <p class="font-medium">{{ $vehicle->vehicleType->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Année</p>
                        <p class="font-medium">{{ $vehicle->year }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kilométrage</p>
                        <p class="font-medium">{{ number_format($vehicle->mileage, 0, ',', ' ') }} km</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Carburant</p>
                        <p class="font-medium">{{ ucfirst($vehicle->fuel_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Transmission</p>
                        <p class="font-medium">{{ ucfirst($vehicle->transmission) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Couleur</p>
                        <p class="font-medium">{{ ucfirst($vehicle->color) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Type d'annonce</p>
                        <p class="font-medium">
                            @if($vehicle->listing_type == 'sale')
                                Vente
                            @elseif($vehicle->listing_type == 'rent')
                                Location
                            @elseif($vehicle->listing_type == 'both')
                                Vente et Location
                            @else
                                Non spécifié
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Prix de vente</p>
                        <p class="font-medium">{{ number_format($vehicle->price, 0, ',', ' ') }} FCFA</p>
                    </div>
                    @if($vehicle->listing_type == 'rent' || $vehicle->listing_type == 'both')
                    <div>
                        <p class="text-sm text-gray-500">Prix de location</p>
                        <p class="font-medium">
                            {{ number_format($vehicle->rental_price, 0, ',', ' ') }} FCFA
                            @if($vehicle->rental_period == 'day')
                                / jour
                            @elseif($vehicle->rental_period == 'week')
                                / semaine
                            @elseif($vehicle->rental_period == 'month')
                                / mois
                            @endif
                        </p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500">Date d'ajout</p>
                        <p class="font-medium">{{ $vehicle->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Description du véhicule -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Description</h3>
                <div class="prose max-w-none">
                    {!! nl2br(e($vehicle->description)) !!}
                </div>
            </div>

            <!-- Informations du vendeur -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations du vendeur</h3>
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-drive-teal text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $vehicle->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $vehicle->user->email }}</div>
                    </div>
                    <a href="{{ route('admin.users.show', $vehicle->user->id) }}" class="ml-auto text-drive-teal hover:underline">
                        Voir le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
