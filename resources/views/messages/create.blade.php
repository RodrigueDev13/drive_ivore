@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-bold">Nouveau message</h2>
            @if($vehicle)
                <p class="text-sm text-gray-600">À propos de: {{ $vehicle->title }}</p>
            @endif
        </div>

        <div class="p-6">
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf

                @if($vehicle)
                    <input type="hidden" name="recipient_id" value="{{ $vehicle->user_id }}">
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                @else
                    <div class="mb-4">
                        <label for="recipient_id" class="block text-sm font-medium text-gray-700 mb-1">Destinataire</label>
                        <select name="recipient_id" id="recipient_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                            <option value="">Sélectionnez un destinataire</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea name="content" id="content" rows="5" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md hover:bg-teal-600 transition">
                        Envoyer le message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
