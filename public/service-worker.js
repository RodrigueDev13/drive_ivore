// Service Worker pour Drive Ivoire
const CACHE_NAME = 'drive-ivoire-cache-v1';

// Liste des ressources à mettre en cache immédiatement
const INITIAL_CACHED_RESOURCES = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/js/message-realtime.js',
    '/manifest.json',
    '/favicon.ico',
    // Ajoutez d'autres ressources statiques importantes ici
];

// Installation du Service Worker
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('Cache ouvert');
                return cache.addAll(INITIAL_CACHED_RESOURCES);
            })
            .then(() => {
                return self.skipWaiting();
            })
    );
});

// Activation du Service Worker
self.addEventListener('activate', (event) => {
    const cacheWhitelist = [CACHE_NAME];
    
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        // Supprimer les caches obsolètes
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => {
            return self.clients.claim();
        })
    );
});

// Stratégie de mise en cache : Cache First, puis réseau
self.addEventListener('fetch', (event) => {
    // Ne pas mettre en cache les requêtes API
    if (event.request.url.includes('/api/') || 
        event.request.url.includes('/check-new-messages') ||
        event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                // Cache hit - retourner la réponse du cache
                if (response) {
                    // Pour les pages HTML, vérifier le réseau en arrière-plan pour les mises à jour
                    if (event.request.headers.get('accept').includes('text/html')) {
                        const fetchPromise = fetch(event.request).then((networkResponse) => {
                            // Mettre à jour le cache avec la nouvelle version
                            if (networkResponse && networkResponse.status === 200) {
                                const responseToCache = networkResponse.clone();
                                caches.open(CACHE_NAME).then((cache) => {
                                    cache.put(event.request, responseToCache);
                                });
                            }
                            return networkResponse;
                        }).catch(() => {
                            // En cas d'échec du réseau, utiliser la version en cache
                            return response;
                        });
                        
                        // Pour les pages HTML, utiliser le réseau si disponible, sinon le cache
                        return fetchPromise || response;
                    }
                    
                    return response;
                }

                // Pas de correspondance dans le cache - récupérer depuis le réseau
                return fetch(event.request)
                    .then((networkResponse) => {
                        // Vérifier si la réponse est valide
                        if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
                            return networkResponse;
                        }

                        // Mettre en cache la réponse pour les futures requêtes
                        const responseToCache = networkResponse.clone();
                        caches.open(CACHE_NAME)
                            .then((cache) => {
                                cache.put(event.request, responseToCache);
                            });

                        return networkResponse;
                    })
                    .catch(() => {
                        // Si la requête échoue (par exemple, pas de connexion),
                        // tenter de servir la page offline
                        if (event.request.headers.get('accept').includes('text/html')) {
                            return caches.match('/offline.html');
                        }
                    });
            })
    );
});

// Gestion des messages push
self.addEventListener('push', (event) => {
    if (event.data) {
        const data = event.data.json();
        
        const options = {
            body: data.body || 'Nouveau message',
            icon: '/images/icons/icon-192x192.png',
            badge: '/images/icons/icon-72x72.png',
            data: {
                url: data.url || '/'
            }
        };
        
        event.waitUntil(
            self.registration.showNotification(data.title || 'Drive Ivoire', options)
        );
    }
});

// Gestion des clics sur les notifications
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    
    if (event.notification.data && event.notification.data.url) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    }
});
