@extends('layouts.app')

@section('title', 'Page non trouvée')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-md mx-auto text-center">
        <h1 class="text-6xl font-bold text-drive-teal mb-4">404</h1>
        <h2 class="text-2xl font-semibold mb-4">Page non trouvée</h2>
        <p class="text-gray-600 mb-8">La page que vous recherchez n'existe pas ou a été déplacée.</p>
        <a href="{{ route('home') }}" class="inline-block bg-drive-teal text-white px-6 py-3 rounded-lg hover:bg-opacity-90">
            Retour à l'accueil
        </a>
    </div>
</div>
@endsection
