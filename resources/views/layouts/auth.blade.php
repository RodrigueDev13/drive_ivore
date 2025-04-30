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
<body class="bg-drive-teal sm:bg-gray-100 min-h-screen">
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- CSRF Token pour les requêtes AJAX -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    
    <!-- Script PWA -->
    <script src="{{ asset('js/pwa.js') }}"></script>
    
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
