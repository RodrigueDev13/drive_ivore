@extends('layouts.app')

@section('title', 'Bienvenue')

@section('content')
<div class="flex flex-col items-center justify-between h-full py-16 px-8 bg-white">
    <div class="flex-1 flex items-center justify-center w-full">
        <div class="w-full max-w-[240px]">
            <img src="{{ asset('images/logo.png') }}" alt="Drive Ivoire Logo" class="w-full">
        </div>
    </div>
    <div class="w-full space-y-4">
        <a href="{{ route('register') }}" class="block w-full bg-drive-teal hover:bg-opacity-90 text-white font-medium py-3 text-center rounded">
            S'INSCRIRE
        </a>
        <a href="{{ route('login') }}" class="block w-full text-center text-sm font-medium text-gray-700">
            J'AI DÉJÀ UN COMPTE ?
        </a>
    </div>
    <div class="mt-8 text-xs text-gray-400">WANGO-TECH</div>
</div>
@endsection
