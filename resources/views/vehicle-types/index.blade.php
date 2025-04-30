@extends('layouts.app')

@section('title', 'Types de véhicules')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center mb-6">
            <a href="{{ route('home') }}" class="text-drive-teal hover:underline mr-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à l'accueil
            </a>
            <h1 class="text-3xl font-bold text-drive-teal">Types de véhicules</h1>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($vehicleTypes as $type)
                <a href="{{ route('vehicles.by-type', $type) }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="w-20 h-20 mx-auto mb-3 flex items-center justify-center bg-gray-100 rounded-full">
                        <img src="{{ $type->icon_url }}" alt="{{ $type->name }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="font-medium text-lg">{{ $type->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $type->vehicles_count }} véhicules</p>
                </a>
            @endforeach
        </div>


    </div>
</div>
@endsection
