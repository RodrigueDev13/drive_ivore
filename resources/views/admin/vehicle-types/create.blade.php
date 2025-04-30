@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.vehicle-types.index') }}" class="text-drive-teal hover:underline mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-drive-teal">Ajouter un type de véhicule</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.vehicle-types.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom du type</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icône -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icône</label>
                    <input type="file" name="icon" id="icon" accept="image/*" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('icon') border-red-500 @enderror">
                    <p class="text-gray-500 text-xs mt-1">Formats acceptés : JPG, PNG, GIF. Taille maximale : 2 Mo.</p>
                    @error('icon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.vehicle-types.index') }}" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 transition mr-2">
                    Annuler
                </a>
                <button type="submit" class="bg-drive-teal text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition">
                    Créer le type
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
