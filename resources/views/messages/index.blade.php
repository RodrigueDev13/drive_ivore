@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Mes messages</h1>

    @if(count($conversations) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="divide-y divide-gray-200">
                @foreach($conversations as $item)
                    <a href="{{ route('messages.show', $item['user']->id) }}" class="block hover:bg-gray-50 transition">
                        <div class="p-4 flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-medium {{ $item['message']->read_at === null && $item['message']->user_id !== auth()->id() ? 'text-teal-600 font-bold' : 'text-gray-900' }}">
                                        {{ $item['user']->name }}
                                    </h3>
                                    <span class="text-sm text-gray-500">{{ $item['message']->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">
                                    @if($item['message']->user_id === auth()->id())
                                        <span class="text-gray-400">Vous: </span>
                                    @endif
                                    {{ $item['message']->content }}
                                </p>
                                @if($item['conversation']->vehicle_id)
                                    <div class="mt-1 text-xs text-teal-600">
                                        À propos de: {{ $item['conversation']->vehicle->title }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
            <h3 class="text-xl font-bold mb-2">Aucun message</h3>
            <p class="text-gray-600">Vous n'avez pas encore de conversations.</p>
        </div>
    @endif
</div>
@endsection
