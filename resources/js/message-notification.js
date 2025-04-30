// Système de notification pour les messages
document.addEventListener('DOMContentLoaded', function() {
    // Ne pas exécuter si l'utilisateur n'est pas connecté
    if (!document.body.classList.contains('user-authenticated')) {
        return;
    }

    let lastMessageId = 0;
    let checkInterval = 10000; // Vérifier toutes les 10 secondes
    let currentPage = window.location.pathname;
    let isMessagePage = currentPage.includes('/messages');

    // Fonction pour vérifier les nouveaux messages
    async function checkNewMessages() {
        try {
            const response = await fetch('/api/check-messages', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Erreur lors de la vérification des messages');
            }
            
            const data = await response.json();
            
            // Mettre à jour les badges de notification
            updateNotificationBadges(data.unread_count);
            
            // Si nous sommes sur une page de messages et qu'il y a un nouveau message
            if (isMessagePage && data.last_message_id > lastMessageId && lastMessageId !== 0) {
                // Actualiser la page
                window.location.reload();
            }
            
            // Mettre à jour l'ID du dernier message
            if (data.last_message_id > 0) {
                lastMessageId = data.last_message_id;
            }
            
        } catch (error) {
            console.error('Erreur:', error);
        }
    }
    
    // Fonction pour mettre à jour les badges de notification
    function updateNotificationBadges(count) {
        // Mettre à jour le badge dans la navigation desktop
        const desktopBadge = document.getElementById('desktop-message-badge');
        if (desktopBadge) {
            if (count > 0) {
                desktopBadge.textContent = count;
                desktopBadge.classList.remove('hidden');
            } else {
                desktopBadge.classList.add('hidden');
            }
        }
        
        // Mettre à jour le badge dans la navigation mobile
        const mobileBadge = document.getElementById('mobile-message-badge');
        if (mobileBadge) {
            if (count > 0) {
                mobileBadge.textContent = count;
                mobileBadge.classList.remove('hidden');
            } else {
                mobileBadge.classList.add('hidden');
            }
        }
    }
    
    // Vérifier les messages immédiatement au chargement de la page
    checkNewMessages();
    
    // Puis vérifier périodiquement
    setInterval(checkNewMessages, checkInterval);
});
