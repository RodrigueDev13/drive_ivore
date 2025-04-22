@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="h-full bg-white flex flex-col">
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Hero Section -->
        <div class="bg-drive-teal p-6 text-white">
            <h1 class="text-xl font-bold mb-2">Vends tes Véhicules !</h1>
            <p class="text-sm mb-4">
                Vends tes véhicules au meilleur prix. Ajoute ta marque et le modèle, et commence à vendre.
            </p>
            <a href="{{ route('vehicles.create') }}" class="inline-block bg-drive-yellow hover:bg-opacity-90 text-white font-medium px-6 py-2 text-sm rounded">
                VENDRE
            </a>
        </div>

        <!-- Vehicle Types -->
        <div class="p-4">
            <h2 class="text-gray-700 font-medium mb-3">Types de véhicule</h2>
            <div class="flex justify-between">
                @foreach($vehicleTypes as $type)
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 mb-1">
                        <img src="{{ asset($type->icon) }}" alt="{{ $type->name }}" class="w-full h-full object-contain">
                    </div>
                    <span class="text-xs text-gray-600">{{ $type->name }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Popular Articles -->
        <div class="p-4">
            <h2 class="text-gray-700 font-medium mb-3">Articles populaires</h2>
            @if($featuredVehicle)
            <div class="bg-gray-100 rounded-lg overflow-hidden">
                <img src="{{ asset($featuredVehicle->images->first()->path ?? 'images/placeholder.jpg') }}"
                     alt="{{ $featuredVehicle->brand->name }} {{ $featuredVehicle->model }}"
                     class="w-full h-[180px] object-cover">
            </div>
            @else
            <div class="bg-gray-100 rounded-lg overflow-hidden h-[180px] flex items-center justify-center">
                <p class="text-gray-500">Aucun véhicule disponible</p>
            </div>
            @endif
        </div>

        <!-- Brands -->
        <div class="p-4">
            <h2 class="text-gray-700 font-medium mb-3">Marques</h2>
            <div class="flex gap-2 flex-wrap">
                @foreach($brands as $brand)
                <div class="flex items-center gap-1 bg-gray-100 rounded-full px-3 py-1">
                    <div class="w-5 h-5">
                        <img src="{{ asset($brand->icon) }}" alt="{{ $brand->name }}" class="w-full h-full object-contain">
                    </div>
                    <span class="text-xs">{{ $brand->name }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    @include('components.bottom-navigation')
</div>
@endsection
