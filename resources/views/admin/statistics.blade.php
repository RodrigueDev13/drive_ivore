@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-drive-teal mb-8">Statistiques</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Statistiques des utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Utilisateurs inscrits</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($userStats as $stat)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $stat->date }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $stat->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-2 px-4 border-b border-gray-200 text-center text-gray-500">Aucune donnée disponible</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistiques des véhicules -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Véhicules ajoutés</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicleStats as $stat)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $stat->date }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $stat->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-2 px-4 border-b border-gray-200 text-center text-gray-500">Aucune donnée disponible</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Résumé global</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Total utilisateurs</h3>
                <p class="text-2xl font-bold text-drive-teal">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Total véhicules</h3>
                <p class="text-2xl font-bold text-drive-teal">{{ \App\Models\Vehicle::count() }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Total marques</h3>
                <p class="text-2xl font-bold text-drive-teal">{{ \App\Models\Brand::count() }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Total types</h3>
                <p class="text-2xl font-bold text-drive-teal">{{ \App\Models\VehicleType::count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
