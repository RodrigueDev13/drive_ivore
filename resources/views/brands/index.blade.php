@extends('layouts.app')

@section('title', 'Marques de véhicules')

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
            <h1 class="text-3xl font-bold text-drive-teal">Marques de véhicules</h1>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-6">
            @foreach($brands as $brand)
                <a href="{{ route('vehicles.by-brand', $brand) }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="w-20 h-20 mx-auto mb-3 flex items-center justify-center bg-gray-100 rounded-full">
                        <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="font-medium text-lg">{{ $brand->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $brand->vehicles_count }} véhicules</p>
                </a>
            @endforeach
        </div>


    </div>
</div>
@endsection
