@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center">
    <div class="container mx-auto px-4 w-full max-w-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Redirect Message -->
        @if(isset($message))
        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg relative">
            <span class="block sm:inline">{{ $message }}</span>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Redirect Field (hidden) -->
                    @if(isset($redirect))
                    <input type="hidden" name="redirect" value="{{ $redirect }}">
                    @endif

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-drive-teal shadow-sm focus:border-drive-teal focus:ring focus:ring-drive-teal focus:ring-opacity-50" name="remember">
                            <span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-drive-teal hover:underline" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif

                        <button type="submit" class="bg-drive-teal text-white px-6 py-2 rounded-lg hover:bg-opacity-90">
                            Se connecter
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Vous n'avez pas de compte ?</p>
                    <a href="{{ route('register') }}" class="mt-2 inline-block bg-drive-yellow text-white px-6 py-2 rounded-lg hover:bg-opacity-90">
                        Créer un compte
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
