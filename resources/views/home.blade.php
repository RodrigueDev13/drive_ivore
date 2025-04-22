@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <!-- Hero Section -->
    <div class="bg-drive-teal text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">Bienvenue sur Drive Ivoire</h1>
                <p class="text-xl mb-8">La meilleure plateforme pour acheter et vendre des véhicules en Côte d'Ivoire</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('vehicles.index') }}" class="bg-white text-drive-teal hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold">
                        Voir les véhicules
                    </a>
                    <a href="{{ route('vehicles.create') }}" class="bg-drive-yellow text-white hover:bg-opacity-90 px-6 py-3 rounded-lg font-semibold">
                        Vendre un véhicule
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recherche rapide -->
    <div class="bg-white py-8 shadow-md">
        <div class="container mx-auto px-4">
            <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                    <select id="brand" name="brand" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="">Toutes les marques</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select id="type" name="type" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="">Tous les types</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix max</label>
                    <select id="price" name="max_price" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="">Tous les prix</option>
                        <option value="5000000">5 000 000 FCFA</option>
                        <option value="10000000">10 000 000 FCFA</option>
                        <option value="15000000">15 000 000 FCFA</option>
                        <option value="20000000">20 000 000 FCFA</option>
                        <option value="30000000">30 000 000 FCFA</option>
                        <option value="50000000">50 000 000 FCFA</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-drive-teal text-white p-2 rounded-md hover:bg-opacity-90">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Véhicules mis en avant -->
    <div class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Véhicules à la une</h2>

            @if($featuredVehicles->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredVehicles as $vehicle)
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
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="block text-center bg-drive-teal text-white py-2 rounded hover:bg-opacity-90">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-100 p-6 rounded-lg text-center">
                    <p class="text-gray-600">Aucun véhicule mis en avant pour le moment.</p>
                </div>
            @endif

            <div class="mt-8 text-center">
                <a href="{{ route('vehicles.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
                    Voir tous les véhicules
                </a>
            </div>
        </div>
    </div>

    <!-- Types de véhicules -->
    <div class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Parcourir par type</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($vehicleTypes as $type)
                    <a href="{{ route('vehicles.by-type', $type) }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="w-16 h-16 mx-auto mb-2">
                            <img src="{{ asset($type->icon) }}" alt="{{ $type->name }}" class="w-full h-full object-contain">
                        </div>
                        <h3 class="font-medium">{{ $type->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $type->vehicles_count }} véhicules</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Marques populaires -->
    <div class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Marques populaires</h2>

            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-4">
                @foreach($brands as $brand)
                    <a href="{{ route('vehicles.by-brand', $brand) }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="w-16 h-16 mx-auto mb-2">
                            <img src="{{ asset($brand->icon) }}" alt="{{ $brand->name }}" class="w-full h-full object-contain">
                        </div>
                        <h3 class="font-medium">{{ $brand->name }}</h3>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('brands.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
                    Voir toutes les marques
                </a>
            </div>
        </div>
    </div>

    <!-- Derniers véhicules ajoutés -->
    <div class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Derniers véhicules ajoutés</h2>

            @if($recentVehicles->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($recentVehicles as $vehicle)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="h-40 overflow-hidden">
                                <img src="{{ asset('storage/' . $vehicle->primaryImage) }}" alt="{{ $vehicle->brand->name }} {{ $vehicle->model }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">{{ $vehicle->brand->name }} {{ $vehicle->model }}</h3>
                                <div class="flex justify-between mb-2">
                                    <span class="text-drive-teal font-bold">{{ $vehicle->formattedPrice }}</span>
                                    <span class="text-gray-600">{{ $vehicle->year }}</span>
                                </div>
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="block text-center bg-drive-teal text-white py-2 rounded hover:bg-opacity-90 mt-2">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-200 p-6 rounded-lg text-center">
                    <p class="text-gray-600">Aucun véhicule disponible pour le moment.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pourquoi nous choisir -->
    <div class="hidden md:block bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 text-center">Pourquoi choisir Drive Ivoire ?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="w-16 h-16 bg-drive-teal rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fiabilité</h3>
                    <p class="text-gray-600">Tous nos véhicules sont vérifiés et les vendeurs sont identifiés pour garantir votre sécurité.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="w-16 h-16 bg-drive-teal rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Simplicité</h3>
                    <p class="text-gray-600">Notre plateforme est facile à utiliser pour acheter ou vendre un véhicule en quelques clics.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="w-16 h-16 bg-drive-teal rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Assistance</h3>
                    <p class="text-gray-600">Notre équipe est disponible pour vous accompagner tout au long de votre processus d'achat ou de vente.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
