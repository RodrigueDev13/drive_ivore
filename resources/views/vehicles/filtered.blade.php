@extends('layouts.app')

@section('title', $title ?? 'Véhicules')

@section('content')
<div class="h-full bg-white flex flex-col">
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header Section -->
        <div class="bg-drive-teal p-6 text-white">
            <h1 class="text-xl font-bold mb-2">{{ $title }}</h1>
            <p class="text-sm mb-4">
                Découvrez notre sélection de véhicules.
            </p>
            <a href="{{ route('vehicles.create') }}" class="inline-block bg-drive-yellow hover:bg-opacity-90 text-white font-medium px-6 py-2 text-sm rounded">
                VENDRE
            </a>
        </div>

        <!-- Vehicles Grid -->
        <div class="p-4">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($vehicles as $vehicle)
                    <a href="{{ route('vehicles.show', $vehicle) }}" class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <div class="relative h-36">
                            @if($vehicle->images->count() > 0)
                                <img src="{{ $vehicle->images->first()->url }}" 
                                     alt="{{ $vehicle->brand->name }} {{ $vehicle->model }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($vehicle->is_featured)
                                <span class="absolute top-2 right-2 bg-drive-yellow text-white text-xs font-bold px-2 py-1 rounded">
                                    Vedette
                                </span>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="font-medium text-sm">{{ $vehicle->brand->name }} {{ $vehicle->model }}</h3>
                            <p class="text-drive-teal font-bold">{{ number_format($vehicle->price, 0, ',', ' ') }} FCFA</p>
                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                <span class="mr-2">{{ $vehicle->year }}</span>
                                <span>{{ $vehicle->mileage }} km</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-gray-100 rounded-lg p-8 text-center">
                        <p class="text-gray-500">Aucun véhicule disponible</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    @include('components.bottom-navigation')
</div>
@endsection
