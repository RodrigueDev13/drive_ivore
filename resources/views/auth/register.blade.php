@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center py-4 sm:py-6 text-white sm:text-gray-800">
    <div class="container mx-auto px-3 sm:px-4 w-full max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden text-gray-800">
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3 sm:mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50 text-sm sm:text-base py-2">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3 sm:mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- User Type -->
                    <div class="mb-3 sm:mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type de compte</label>
                        <div class="mt-1 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="mt-4" x-data="{userType: 'particulier', isSeller: false}">
                                <div class="flex items-center">
                                    <input type="radio" id="particulier" name="user_type" value="particulier" class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300" checked x-model="userType">
                                    <label for="particulier" class="ml-2 block text-sm text-gray-900">Particulier</label>
                                </div>
                                <div class="flex items-center mt-2">
                                    <input type="radio" id="entreprise" name="user_type" value="entreprise" class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300" x-model="userType">
                                    <label for="entreprise" class="ml-2 block text-sm text-gray-900">Entreprise</label>
                                </div>
                                
                                <!-- Option "Je suis vendeur" pour les particuliers -->
                                <div class="flex items-center mt-3" x-show="userType === 'particulier'" x-cloak>
                                    <input type="checkbox" id="is_seller" name="is_seller" value="1" class="h-4 w-4 text-drive-teal focus:ring-drive-teal border-gray-300" x-model="isSeller">
                                    <label for="is_seller" class="ml-2 block text-sm text-gray-900">Je suis vendeur</label>
                                </div>
                            </div>
                        <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3 sm:mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3 sm:mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-5 sm:mt-6">
                        <button type="submit" class="w-full bg-drive-teal text-white py-2 px-4 rounded-lg hover:bg-opacity-90 text-sm sm:text-base">
                            Créer mon compte
                        </button>
                    </div>
                </form>

                <div class="mt-4 pt-4 sm:mt-6 sm:pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Vous avez déjà un compte ?</p>
                    <a href="{{ route('login') }}" class="mt-2 inline-block text-drive-teal hover:underline">
                        Se connecter
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-5 sm:mt-8 bg-white sm:bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200 text-gray-800" x-data="{ expanded: false }">
            <div class="flex justify-between items-center cursor-pointer" @click="expanded = !expanded">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Pourquoi rejoindre Drive Ivoire ?</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-drive-teal transition-transform duration-300" :class="{'rotate-180': expanded}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
            
            <!-- Contenu déployé -->
            <div x-show="expanded" x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 transform -translate-y-4" 
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                 class="mt-4">
                <ul class="space-y-2 sm:space-y-3">
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-drive-teal mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Publiez vos annonces de véhicules facilement</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-drive-teal mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Trouvez votre véhicule idéal parmi nos nombreuses annonces</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-drive-teal mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Communiquez directement avec les vendeurs ou acheteurs</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-drive-teal mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Accédez à des outils exclusifs pour gérer vos annonces et vos favoris</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-drive-teal mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Bénéficiez d'une visibilité accrue pour vos véhicules à vendre ou à louer</span>
                    </li>
                </ul>
                <p class="mt-3 sm:mt-4 text-gray-600 text-xs sm:text-sm">
                    Drive Ivoire est la plateforme de référence en Côte d'Ivoire pour l'achat, la vente et la location de véhicules. 
                    Rejoignez notre communauté grandissante et profitez d'une expérience utilisateur optimale pour toutes vos transactions automobiles.
                </p>
            </div>
            <!-- Bouton pour en savoir plus (visible quand non déployé) -->
            <div x-show="!expanded" class="mt-3 text-center">
                <button type="button" @click="expanded = true" class="text-drive-teal font-medium text-sm hover:underline focus:outline-none">
                    En savoir plus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
