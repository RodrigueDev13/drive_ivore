@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="bg-drive-teal text-white py-10">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-2">Mon Profil</h1>
            <p class="text-lg">Gérez vos informations personnelles et vos annonces</p>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-20 h-20 bg-drive-teal rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <p class="text-gray-500 text-sm">Membre depuis {{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 mt-4">
                    <a href="{{ route('profile.edit') }}" class="bg-drive-teal text-white px-4 py-2 rounded-lg hover:bg-opacity-90 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Modifier mon profil
                    </a>
                    
                    @if($user->user_type === 'entreprise')
                    <a href="{{ route('profile.company.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2a1 1 0 00-1-1H7a1 1 0 00-1 1v2a1 1 0 01-1 1H3a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                        </svg>
                        Profil entreprise
                        @if(!$user->hasCompletedCompanyProfile())
                            <span class="ml-1 bg-red-500 text-white text-xs px-2 py-1 rounded-full">À compléter</span>
                        @endif
                    </a>
                    @endif
                    
                    @if($user->user_type === 'particulier' && $user->is_seller)
                    <a href="{{ route('profile.seller.edit') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Profil vendeur
                        @if(!$user->hasCompletedSellerProfile())
                            <span class="ml-1 bg-red-500 text-white text-xs px-2 py-1 rounded-full">À compléter</span>
                        @endif
                    </a>
                    @endif
                    <a href="{{ route('profile.vehicles') }}" class="bg-drive-yellow text-white px-4 py-2 rounded-lg hover:bg-opacity-90 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1h3a1 1 0 001-1v-3a1 1 0 00-.293-.707l-2-2A1 1 0 0012 7h-1V5a1 1 0 00-1-1H3z" />
                        </svg>
                        Mes véhicules
                    </a>
                    <a href="{{ route('favorites.index') }}" class="bg-white border border-drive-teal text-drive-teal px-4 py-2 rounded-lg hover:bg-gray-50 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        Mes favoris
                    </a>
                    <a href="{{ route('messages.index') }}" class="bg-white border border-drive-teal text-drive-teal px-4 py-2 rounded-lg hover:bg-gray-50 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                        Mes messages
                    </a>
                    
                    @if($user->is_admin)
                    <a href="{{ route('admin.index') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Administration
                    </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="border-b border-gray-200">
                <h3 class="text-lg font-semibold px-6 py-4">Statistiques</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-drive-teal mb-1">{{ $user->vehicles->count() }}</div>
                        <div class="text-gray-600">Véhicules publiés</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-drive-teal mb-1">{{ $user->favorites->count() }}</div>
                        <div class="text-gray-600">Favoris</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-drive-teal mb-1">{{ $user->created_at->diffInDays() }}</div>
                        <div class="text-gray-600">Jours sur Drive Ivoire</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200">
                <h3 class="text-lg font-semibold px-6 py-4">Dernières activités</h3>
            </div>
            <div class="p-6">
                @if($user->vehicles->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->vehicles->sortByDesc('created_at')->take(3) as $vehicle)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-16 h-16 bg-gray-200 rounded-md overflow-hidden mr-4">
                                    @if($vehicle->images->count() > 0)
                                        <img src="{{ asset('storage/' . $vehicle->images->first()->path) }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold">{{ $vehicle->title }}</h4>
                                    <p class="text-sm text-gray-600">Publié le {{ $vehicle->created_at->format('d/m/Y') }}</p>
                                </div>
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="text-drive-teal hover:underline">
                                    Voir
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        <p>Vous n'avez pas encore publié de véhicules.</p>
                        @if($user->isSeller())
                            @if($user->canCreateVehicleListing())
                                <a href="{{ route('vehicles.create') }}" class="inline-block mt-2 bg-drive-yellow text-white px-4 py-2 rounded-lg hover:bg-opacity-90">
                                    Publier un véhicule
                                </a>
                            @else
                                @if($user->user_type === 'entreprise')
                                    <a href="{{ route('profile.company.edit') }}" class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                        Compléter mon profil entreprise pour publier
                                    </a>
                                @elseif($user->user_type === 'particulier' && $user->is_seller)
                                    <a href="{{ route('profile.seller.edit') }}" class="inline-block mt-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                        Compléter mon profil vendeur pour publier
                                    </a>
                                @endif
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection