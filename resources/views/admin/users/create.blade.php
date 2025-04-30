@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-drive-teal hover:underline mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-drive-teal">Ajouter un utilisateur</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-drive-teal focus:border-drive-teal">
            </div>

            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }} 
                        class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300 rounded">
                    <label for="is_admin" class="ml-2 block text-sm text-gray-700">Administrateur</label>
                </div>
                <p class="text-gray-500 text-xs mt-1">Les administrateurs ont accès au tableau de bord d'administration et à toutes les fonctionnalités de gestion.</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Type d'utilisateur</label>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input type="radio" name="user_type" id="user_type_particulier" value="particulier" {{ old('user_type', 'particulier') === 'particulier' ? 'checked' : '' }} 
                            class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300">
                        <label for="user_type_particulier" class="ml-2 block text-sm text-gray-700">Particulier</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="user_type" id="user_type_entreprise" value="entreprise" {{ old('user_type') === 'entreprise' ? 'checked' : '' }} 
                            class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300">
                        <label for="user_type_entreprise" class="ml-2 block text-sm text-gray-700">Entreprise</label>
                    </div>
                </div>
                @error('user_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="seller_section" class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_seller" id="is_seller" value="1" {{ old('is_seller') ? 'checked' : '' }} 
                        class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300 rounded">
                    <label for="is_seller" class="ml-2 block text-sm text-gray-700">Vendeur</label>
                </div>
                <p class="text-gray-500 text-xs mt-1">Les vendeurs peuvent publier des annonces de véhicules. Pour les entreprises, ce statut est automatiquement activé.</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 transition mr-2">
                    Annuler
                </a>
                <button type="submit" class="bg-drive-teal text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition">
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userTypeParticulier = document.getElementById('user_type_particulier');
        const userTypeEntreprise = document.getElementById('user_type_entreprise');
        const sellerSection = document.getElementById('seller_section');

        function toggleSellerSection() {
            if (userTypeEntreprise.checked) {
                sellerSection.style.display = 'none';
            } else {
                sellerSection.style.display = 'block';
            }
        }

        userTypeParticulier.addEventListener('change', toggleSellerSection);
        userTypeEntreprise.addEventListener('change', toggleSellerSection);

        // Initial toggle based on current selection
        toggleSellerSection();
    });
</script>
@endpush

@endsection
