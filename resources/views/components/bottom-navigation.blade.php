{{-- @php
    $currentRoute = Route::currentRouteName();
@endphp

<div class="h-16 border-t flex justify-between items-center px-4 bg-white">
    <a href="{{ route('vehicles.index') }}" class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ str_starts_with($currentRoute, 'vehicles.') ? 'text-drive-teal' : 'text-gray-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span class="text-xs {{ str_starts_with($currentRoute, 'vehicles.') ? 'text-drive-teal' : 'text-gray-600' }}">Accueil</span>
    </a>

    <a href="{{ route('favorites.index') }}" class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $currentRoute === 'favorites.index' ? 'text-drive-teal' : 'text-gray-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
        </svg>
        <span class="text-xs {{ $currentRoute === 'favorites.index' ? 'text-drive-teal' : 'text-gray-600' }}">Favoris</span>
    </a>

    <a href="{{ route('vehicles.create') }}" class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $currentRoute === 'vehicles.create' ? 'text-drive-teal' : 'text-gray-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
            <path d="M3 6h18"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <span class="text-xs {{ $currentRoute === 'vehicles.create' ? 'text-drive-teal' : 'text-gray-600' }}">Vendre</span>
    </a>

    <a href="{{ route('messages.index') }}" class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ str_starts_with($currentRoute, 'messages.') ? 'text-drive-teal' : 'text-gray-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
        </svg>
        <span class="text-xs {{ str_starts_with($currentRoute, 'messages.') ? 'text-drive-teal' : 'text-gray-600' }}">Message</span>
    </a>

    <a href="{{ route('profile.index') }}" class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ str_starts_with($currentRoute, 'profile.') ? 'text-drive-teal' : 'text-gray-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        <span class="text-xs {{ str_starts_with($currentRoute, 'profile.') ? 'text-drive-teal' : 'text-gray-600' }}">Profil</span>
    </a>
</div> --}}



<div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t md:hidden z-10">
    <div class="flex justify-around">
        <a href="{{ route('home') }}" class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('home') ? 'text-teal-500' : 'text-gray-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span class="text-xs">Accueil</span>
        </a>

        <a href="{{ route('favorites.index') }}" class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('favorites.*') ? 'text-teal-500' : 'text-gray-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
            <span class="text-xs">Favoris</span>
        </a>

        @if(auth()->check() && auth()->user()->isSeller())
        <a href="{{ route('vehicles.create') }}" class="flex flex-col items-center py-2 px-3 {{ request()->is('sell') ? 'text-teal-500' : 'text-gray-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="text-xs">Vendre</span>
        </a>
        @endif

        <a href="{{ route('messages.index') }}" class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('messages.*') ? 'text-teal-500' : 'text-gray-600' }} relative">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                </svg>
                <span id="mobile-message-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
            </div>
            <span class="text-xs">Message</span>
        </a>

        <a href="{{ route('profile.index') }}" class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('profile.*') ? 'text-teal-500' : 'text-gray-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span class="text-xs">Profil</span>
        </a>
    </div>
</div>
