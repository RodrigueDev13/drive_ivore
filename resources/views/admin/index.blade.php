@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-drive-teal mb-8">Tableau de bord administrateur</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Carte statistique utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Utilisateurs</h2>
                    <p class="text-3xl font-bold text-drive-teal mt-2">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-drive-teal bg-opacity-20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-drive-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-drive-teal hover:underline mt-4 inline-block">Voir tous les utilisateurs →</a>
        </div>

        <!-- Carte statistique véhicules -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Véhicules</h2>
                    <p class="text-3xl font-bold text-drive-teal mt-2">{{ $stats['vehicles'] }}</p>
                </div>
                <div class="bg-drive-teal bg-opacity-20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-drive-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.vehicles.index') }}" class="text-drive-teal hover:underline mt-4 inline-block">Voir tous les véhicules →</a>
        </div>

        <!-- Carte statistique marques -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Marques</h2>
                    <p class="text-3xl font-bold text-drive-teal mt-2">{{ $stats['brands'] }}</p>
                </div>
                <div class="bg-drive-teal bg-opacity-20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-drive-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.brands.index') }}" class="text-drive-teal hover:underline mt-4 inline-block">Voir toutes les marques →</a>
        </div>

        <!-- Carte statistique types de véhicules -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Types de véhicules</h2>
                    <p class="text-3xl font-bold text-drive-teal mt-2">{{ $stats['vehicleTypes'] }}</p>
                </div>
                <div class="bg-drive-teal bg-opacity-20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-drive-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.vehicle-types.index') }}" class="text-drive-teal hover:underline mt-4 inline-block">Voir tous les types →</a>
        </div>
    </div>

    <div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Actions rapides</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.vehicles.create') }}" class="bg-drive-teal text-white py-3 px-4 rounded-lg flex items-center justify-center hover:bg-opacity-90 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter un véhicule
                </a>
                <a href="{{ route('admin.brands.create') }}" class="bg-drive-teal text-white py-3 px-4 rounded-lg flex items-center justify-center hover:bg-opacity-90 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter une marque
                </a>
                <a href="{{ route('admin.vehicle-types.create') }}" class="bg-drive-teal text-white py-3 px-4 rounded-lg flex items-center justify-center hover:bg-opacity-90 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter un type
                </a>
                <a href="{{ route('admin.statistics') }}" class="bg-drive-yellow text-white py-3 px-4 rounded-lg flex items-center justify-center hover:bg-opacity-90 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Voir les statistiques
                </a>
            </div>
        </div>

        <!-- Dernières activités -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Dernières activités</h2>
            <div class="space-y-4">
                <p class="text-gray-600 italic">Les dernières activités seront affichées ici.</p>
                <!-- Ici, vous pourriez ajouter une boucle pour afficher les dernières activités -->
            </div>
        </div>
    </div>
</div>
@endsection
