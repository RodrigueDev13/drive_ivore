@extends('layouts.auth')

@section('title', 'Réinitialisation du mot de passe')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center">
    <div class="container mx-auto px-4 w-full max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Réinitialisation du mot de passe</h2>
                
                <p class="mb-6 text-gray-600">
                    Veuillez choisir un nouveau mot de passe pour votre compte.
                </p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', request()->email) }}" required autofocus
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input id="password" type="password" name="password" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-drive-teal text-white py-2 px-4 rounded-lg hover:bg-opacity-90">
                            Réinitialiser le mot de passe
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Vous vous souvenez de votre mot de passe ?</p>
                    <a href="{{ route('login') }}" class="mt-2 inline-block text-drive-teal hover:underline">
                        Retour à la connexion
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
