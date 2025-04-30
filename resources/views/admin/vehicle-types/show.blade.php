@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.vehicle-types.index') }}" class="text-drive-teal hover:underline mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-drive-teal">Détails du type de véhicule</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    @if($vehicleType->icon)
                        <div class="h-16 w-16 rounded-lg overflow-hidden bg-gray-100 mr-4">
                            <img src="{{ asset('storage/' . $vehicleType->icon) }}" alt="{{ $vehicleType->name }}" class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $vehicleType->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ $vehicleType->vehicles_count }} véhicule(s)</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.vehicle-types.edit', $vehicleType->id) }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                    <form action="{{ route('admin.vehicle-types.destroy', $vehicleType->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de véhicule ?');">
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

            <!-- Description du type de véhicule -->
            @if($vehicleType->description)
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Description</h3>
                    <div class="prose max-w-none">
                        {!! nl2br(e($vehicleType->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Informations du type de véhicule -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">ID</p>
                        <p class="font-medium">{{ $vehicleType->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Slug</p>
                        <p class="font-medium">{{ $vehicleType->slug }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date de création</p>
                        <p class="font-medium">{{ $vehicleType->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Véhicules du type -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Véhicules ({{ $vehicleType->vehicles_count }})</h3>
                
                @if($vehicles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($vehicles as $vehicle)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                <div class="h-40 overflow-hidden">
                                    @if($vehicle->images->count() > 0)
                                        <img src="{{ asset('storage/' . $vehicle->images->first()->path) }}" alt="{{ $vehicle->title }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-800">{{ $vehicle->title }}</h4>
                                    <div class="flex justify-between items-center mt-2">
                                        <p class="text-drive-teal font-bold">{{ number_format($vehicle->price, 0, ',', ' ') }} FCFA</p>
                                        <span class="text-xs text-gray-500">{{ $vehicle->brand->name }}</span>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="text-drive-teal hover:underline text-sm">Voir détails</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        {{ $vehicles->links() }}
                    </div>
                @else
                    <div class="bg-gray-100 rounded-lg p-4 text-center text-gray-500">
                        Aucun véhicule trouvé pour ce type
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
