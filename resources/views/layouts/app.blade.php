<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Drive Ivoire - {{ $title ?? 'Achetez et vendez des véhicules en Côte d\'Ivoire' }}</title>
    <meta name="description" content="{{ $description ?? 'Drive Ivoire - Le meilleur site pour acheter et vendre des véhicules en Côte d\'Ivoire' }}">
    
    <!-- Méta-tags PWA -->
    <meta name="theme-color" content="#10b981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Drive Ivoire">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 min-h-screen pb-16 md:pb-0 {{ auth()->check() ? 'user-authenticated' : '' }}">
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-teal-500">DRIVE IVOIRE</a>

                <!-- Navigation desktop - liens du menu mobile ajoutés ici -->
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-teal-500 {{ request()->routeIs('home') ? 'text-teal-500' : '' }}">Accueil</a>
                    <a href="{{ route('favorites.index') }}" class="text-gray-700 hover:text-teal-500 {{ request()->routeIs('favorites.*') ? 'text-teal-500' : '' }}">Favoris</a>
                    @if(auth()->check() && auth()->user()->isSeller())
                        <a href="{{ route('vehicles.create') }}" class="text-gray-700 hover:text-teal-500 {{ request()->is('sell') ? 'text-teal-500' : '' }}">Vendre</a>
                    @endif
                    <a href="{{ route('messages.index') }}" class="text-gray-700 hover:text-teal-500 {{ request()->routeIs('messages.*') ? 'text-teal-500' : '' }} relative">
                        Messages
                        <span id="desktop-message-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                    </a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" :class="{'transform rotate-180': open}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                        @if(auth()->user()->isSeller())
                            <a href="{{ route('vehicles.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">Vendre</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-teal-500">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer - masqué sur mobile, visible sur tablette et desktop -->
    <footer class="hidden md:block bg-gray-800 text-white py-10 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">DRIVE IVOIRE</h3>
                    <p class="text-gray-400">La meilleure plateforme pour acheter et vendre des véhicules en Côte d'Ivoire.</p>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Accueil</a></li>
                        <li><a href="{{ route('favorites.index') }}" class="text-gray-400 hover:text-white">Favoris</a></li>
                        <li><a href="{{ route('vehicles.create') }}" class="text-gray-400 hover:text-white">Vendre</a></li>
                        <li><a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-white">Messages</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Informations</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">À propos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            contact@driveivoire.com
                        </li>
                        <li class="flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            +225 07 XX XX XX XX
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Drive Ivoire. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Navigation mobile (visible uniquement sur mobile) -->
    @include('components.bottom-navigation')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- CSRF Token pour les requêtes AJAX -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    
    <!-- Script de notification en temps réel -->
    <script src="{{ asset('js/message-realtime.js') }}"></script>
    
    <!-- Script PWA -->
    <script src="{{ asset('js/pwa.js') }}"></script>
    
    <!-- Bouton d'installation PWA (caché par défaut) -->
    <div id="install-button" class="fixed bottom-20 right-4 bg-teal-500 text-white p-3 rounded-full shadow-lg z-50 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
    </div>
    
    <!-- Notification de connexion hors ligne -->
    <div id="offline-notification" class="fixed top-0 left-0 right-0 bg-red-500 text-white p-2 text-center transform -translate-y-full transition-transform duration-300 z-50">
        Vous êtes hors ligne. Certaines fonctionnalités peuvent ne pas être disponibles.
    </div>
    
    <script>
        // Afficher la notification hors ligne si nécessaire
        document.addEventListener('connection-changed', function(e) {
            const offlineNotification = document.getElementById('offline-notification');
            if (!e.detail.online && offlineNotification) {
                offlineNotification.classList.remove('-translate-y-full');
                setTimeout(function() {
                    offlineNotification.classList.add('-translate-y-full');
                }, 5000);
            }
        });
        
        // Vérifier l'état initial de la connexion
        if (!navigator.onLine) {
            document.dispatchEvent(new CustomEvent('connection-changed', { detail: { online: false } }));
        }
    </script>
    
    <!-- Scripts personnalisés -->
    @stack('scripts')
</body>
</html>
