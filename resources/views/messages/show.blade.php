@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('messages.index') }}" class="inline-flex items-center text-gray-600 hover:text-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Retour aux messages
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold">{{ $otherUser->name }}</h2>
            </div>
            @if($conversation->vehicle_id)
                <p class="text-sm text-gray-600 mt-1">À propos de: {{ $conversation->vehicle->title }}</p>
            @endif
        </div>

        <div class="p-4 h-96 overflow-y-auto" id="messages-container">
            @foreach($messages as $message)
                <div class="mb-4 {{ $message->user_id === auth()->id() ? 'text-right' : 'text-left' }}">
                    <div class="inline-block max-w-3/4 rounded-lg p-3 {{ $message->user_id === auth()->id() ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-800' }}">
                        <p>{{ $message->content }}</p>
                        <div class="mt-1 text-xs {{ $message->user_id === auth()->id() ? 'text-teal-100' : 'text-gray-500' }}">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                            @if($message->user_id === auth()->id() && !is_null($message->read_at))
                                · Lu
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-4 border-t border-gray-200">
            <form action="{{ route('messages.reply', $otherUser->id) }}" method="POST">
                @csrf
                <div class="flex">
                    <input type="text" name="content" placeholder="Écrivez votre message..." required
                        class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-r-md hover:bg-teal-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Faire défiler automatiquement vers le bas pour voir les derniers messages
    document.addEventListener('DOMContentLoaded', function() {
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });
</script>
@endsection
