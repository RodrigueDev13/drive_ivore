@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.brands.index') }}" class="text-drive-teal hover:underline mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-drive-teal">Détails de la marque</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    @if($brand->logo)
                        <div class="h-16 w-16 rounded-lg overflow-hidden bg-gray-100 mr-4">
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $brand->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ $brand->vehicles_count }} véhicule(s)</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette marque ?');">
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

            <!-- Description de la marque -->
            @if($brand->description)
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Description</h3>
                    <div class="prose max-w-none">
                        {!! nl2br(e($brand->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Informations de la marque -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">ID</p>
                        <p class="font-medium">{{ $brand->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Slug</p>
                        <p class="font-medium">{{ $brand->slug }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date de création</p>
                        <p class="font-medium">{{ $brand->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Véhicules de la marque -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Véhicules ({{ $brand->vehicles_count }})</h3>
                
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
                                        <span class="text-xs text-gray-500">{{ $vehicle->year }}</span>
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
                        Aucun véhicule trouvé pour cette marque
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
