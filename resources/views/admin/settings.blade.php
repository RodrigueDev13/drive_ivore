@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-drive-teal mb-8">Paramètres du site</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Paramètres généraux</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nom du site</label>
                        <input type="text" name="site_name" id="site_name" value="{{ old('site_name', 'Drive Ivoire') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal">
                    </div>
                    
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email de contact</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', 'contact@driveivoire.com') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal">
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Réseaux sociaux</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">URL Facebook</label>
                        <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', 'https://facebook.com/driveivoire') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal">
                    </div>
                    
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">URL Instagram</label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', 'https://instagram.com/driveivoire') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal">
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Paramètres d'affichage</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="vehicles_per_page" class="block text-sm font-medium text-gray-700 mb-1">Véhicules par page</label>
                        <input type="number" name="vehicles_per_page" id="vehicles_per_page" value="{{ old('vehicles_per_page', 12) }}" min="1" max="50" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal">
                    </div>
                    
                    <div>
                        <label for="featured_vehicles_count" class="block text-sm font-medium text-gray-700 mb-1">Nombre de véhicules en vedette</label>
                        <input type="number" name="featured_vehicles_count" id="featured_vehicles_count" value="{{ old('featured_vehicles_count', 3) }}" min="1" max="10" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal">
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-drive-teal text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
