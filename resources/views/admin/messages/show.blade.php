@extends('layouts.admin')

@section('title', 'Détails de la conversation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-drive-teal">Détails de la conversation #{{ $conversation->id }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.messages.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
            <form action="{{ route('admin.messages.destroy', $conversation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette conversation ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="border-b border-gray-200 px-6 py-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-drive-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-semibold text-gray-700">Informations</span>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <h5 class="font-bold text-gray-700 mb-3">Utilisateurs</h5>
                        <div class="mb-4">
                            <strong class="text-gray-700">Utilisateur 1:</strong>
                            @if($conversation->userOne)
                                <div class="mt-1 text-gray-900">{{ $conversation->userOne->name }}</div>
                                <div class="text-gray-500 text-sm">{{ $conversation->userOne->email }}</div>
                            @else
                                <span class="text-gray-500">Utilisateur supprimé</span>
                            @endif
                        </div>
                        <div>
                            <strong class="text-gray-700">Utilisateur 2:</strong>
                            @if($conversation->userTwo)
                                <div class="mt-1 text-gray-900">{{ $conversation->userTwo->name }}</div>
                                <div class="text-gray-500 text-sm">{{ $conversation->userTwo->email }}</div>
                            @else
                                <span class="text-gray-500">Utilisateur supprimé</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        <h5 class="font-bold text-gray-700 mb-3">Véhicule concerné</h5>
                        @if($conversation->vehicle)
                            <div>
                                <a href="{{ route('admin.vehicles.show', $conversation->vehicle) }}" target="_blank" class="text-drive-teal hover:text-drive-teal-dark">
                                    {{ $conversation->vehicle->brand->name ?? 'N/A' }} {{ $conversation->vehicle->model }}
                                </a>
                            </div>
                            <div class="text-gray-500 text-sm mt-1">{{ number_format($conversation->vehicle->price, 0, ',', ' ') }} FCFA</div>
                        @else
                            <span class="text-gray-500">Aucun véhicule associé</span>
                        @endif
                    </div>

                    <div>
                        <h5 class="font-bold text-gray-700 mb-3">Dates</h5>
                        <div class="mb-4">
                            <strong class="text-gray-700">Créée le:</strong>
                            <div class="mt-1 text-gray-900">{{ $conversation->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div>
                            <strong class="text-gray-700">Dernier message:</strong>
                            <div class="mt-1">
                                @if($conversation->last_message_at)
                                    <div class="text-gray-900">{{ $conversation->last_message_at->format('d/m/Y H:i') }}</div>
                                    <div class="text-gray-500 text-sm">{{ $conversation->last_message_at->diffForHumans() }}</div>
                                @else
                                    <span class="text-gray-500">Aucun message</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-drive-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span class="font-semibold text-gray-700">Messages</span>
                </div>
                <div class="p-6">
                    <div class="chat-container max-h-[600px] overflow-y-auto">
                        @forelse($messages as $message)
                            <div class="mb-4 p-4 {{ $message->user_id == $conversation->user_one_id ? 'bg-gray-100' : 'bg-blue-50' }} rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900">{{ $message->user->name ?? 'Utilisateur supprimé' }}</span>
                                        @if($message->user_id == $conversation->user_one_id)
                                            <span class="ml-2 px-2 py-0.5 bg-gray-500 text-white text-xs rounded-full">Utilisateur 1</span>
                                        @else
                                            <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full">Utilisateur 2</span>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="text-gray-800">{{ $message->content }}</div>
                                @if($message->read_at)
                                    <div class="text-right mt-2">
                                        <span class="text-xs text-gray-500">Lu le {{ $message->read_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">Aucun message dans cette conversation</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
