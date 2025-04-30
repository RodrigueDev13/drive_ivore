// Script d'enregistrement du Service Worker
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si le Service Worker est supporté
    if ('serviceWorker' in navigator) {
        // Enregistrer le Service Worker
        navigator.serviceWorker.register('/service-worker.js')
            .then(function(registration) {
                console.log('Service Worker enregistré avec succès:', registration.scope);
                
                // Vérifier les mises à jour du Service Worker
                registration.addEventListener('updatefound', function() {
                    console.log('Mise à jour du Service Worker trouvée!');
                    const newWorker = registration.installing;
                    
                    newWorker.addEventListener('statechange', function() {
                        console.log('Nouvel état du Service Worker:', newWorker.state);
                    });
                });
            })
            .catch(function(error) {
                console.error('Erreur lors de l\'enregistrement du Service Worker:', error);
            });
        
        // Vérifier les mises à jour
        navigator.serviceWorker.addEventListener('controllerchange', function() {
            console.log('Service Worker mis à jour, actualisation de la page...');
            window.location.reload();
        });
        
        // Gérer l'état de connexion
        window.addEventListener('online', function() {
            console.log('Connexion Internet rétablie');
            document.dispatchEvent(new CustomEvent('connection-changed', { detail: { online: true } }));
        });
        
        window.addEventListener('offline', function() {
            console.log('Connexion Internet perdue');
            document.dispatchEvent(new CustomEvent('connection-changed', { detail: { online: false } }));
        });
    } else {
        console.log('Les Service Workers ne sont pas supportés par ce navigateur.');
    }
    
    // Gérer l'installation de la PWA
    let deferredPrompt;
    
    window.addEventListener('beforeinstallprompt', function(e) {
        // Empêcher Chrome d'afficher automatiquement l'invite d'installation
        e.preventDefault();
        
        // Stocker l'événement pour l'utiliser plus tard
        deferredPrompt = e;
        
        // Mettre à jour l'interface utilisateur pour informer l'utilisateur qu'il peut installer l'application
        const installButton = document.getElementById('install-button');
        if (installButton) {
            installButton.classList.remove('hidden');
            
            installButton.addEventListener('click', function() {
                // Afficher l'invite d'installation
                deferredPrompt.prompt();
                
                // Attendre que l'utilisateur réponde à l'invite
                deferredPrompt.userChoice.then(function(choiceResult) {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('L\'utilisateur a accepté l\'installation de la PWA');
                        // Masquer le bouton d'installation
                        installButton.classList.add('hidden');
                    } else {
                        console.log('L\'utilisateur a refusé l\'installation de la PWA');
                    }
                    
                    // Réinitialiser la variable deferredPrompt
                    deferredPrompt = null;
                });
            });
        }
    });
    
    // Détecter si l'application est déjà installée
    window.addEventListener('appinstalled', function(e) {
        console.log('Application installée');
        
        // Masquer le bouton d'installation
        const installButton = document.getElementById('install-button');
        if (installButton) {
            installButton.classList.add('hidden');
        }
    });
});
