@extends('layouts.auth')

@section('title', 'Récupération de mot de passe')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center">
    <div class="container mx-auto px-4 w-full max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Récupération de mot de passe</h2>
                
                <p class="mb-6 text-gray-600">
                    Vous avez oublié votre mot de passe ? Pas de problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation.
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-drive-teal text-white py-2 px-4 rounded-lg hover:bg-opacity-90">
                            Envoyer le lien de réinitialisation
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
