@extends('layouts.app')

@section('title', 'Profil d\'entreprise')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Profil d'entreprise</h1>
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Important :</strong> Vous devez compléter votre profil d'entreprise avant de pouvoir créer des annonces de véhicules.
                            </p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('profile.company.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations de base -->
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Informations de base</h2>
                        </div>
                        
                        <!-- Nom de l'entreprise -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise *</label>
                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $companyProfile->company_name ?? '') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                            @error('company_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Numéro d'immatriculation -->
                        <div>
                            <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-1">Numéro d'immatriculation (RCCM)</label>
                            <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number', $companyProfile->registration_number ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                            @error('registration_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Numéro fiscal -->
                        <div>
                            <label for="tax_id" class="block text-sm font-medium text-gray-700 mb-1">Numéro fiscal</label>
                            <input type="text" name="tax_id" id="tax_id" value="{{ old('tax_id', $companyProfile->tax_id ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                            @error('tax_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Numéro de téléphone -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone *</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $companyProfile->phone_number ?? '') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                            @error('phone_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Adresse -->
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2 mt-4">Adresse</h2>
                        </div>
                        
                        <!-- Adresse -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $companyProfile->address ?? '') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Ville -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $companyProfile->city ?? '') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                            @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Informations complémentaires -->
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2 mt-4">Informations complémentaires</h2>
                        </div>
                        
                        <!-- Site web -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Site web</label>
                            <input type="url" name="website" id="website" value="{{ old('website', $companyProfile->website ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50"
                                placeholder="https://www.example.com">
                            @error('website')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Logo -->
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                            <input type="file" name="logo" id="logo"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                            @error('logo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            
                            @if(isset($companyProfile->logo) && $companyProfile->logo)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($companyProfile->logo) }}" alt="Logo" class="h-16 w-auto">
                                </div>
                            @endif
                        </div>
                        
                        <!-- Description -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description de l'entreprise</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">{{ old('description', $companyProfile->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-between items-center">
                        <p class="text-sm text-gray-600">* Champs obligatoires</p>
                        <button type="submit" class="bg-drive-teal text-white py-2 px-6 rounded-lg hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-drive-teal focus:ring-opacity-50">
                            Enregistrer le profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script pour prévisualiser le logo
    document.getElementById('logo').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            // Vérifier si une prévisualisation existe déjà
            let preview = document.querySelector('img[alt="Logo"]');
            
            // Si aucune prévisualisation n'existe, en créer une
            if (!preview) {
                preview = document.createElement('img');
                preview.alt = 'Logo';
                preview.className = 'h-16 w-auto mt-2';
                this.parentNode.appendChild(preview);
            }
            
            preview.src = URL.createObjectURL(file);
        }
    };
</script>
@endpush
