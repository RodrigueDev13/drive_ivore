// Script optimisé pour l'actualisation en temps réel des messages et des notifications
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si l'utilisateur est connecté
    if (!document.body.classList.contains('user-authenticated')) {
        return;
    }

    // Variables globales
    let lastMessageId = 0;
    let lastCheckTime = new Date().getTime();
    let checkInterval = 5000; // Réduit à une vérification toutes les 5 secondes
    let isMessagePage = window.location.pathname.includes('/messages');
    let isConversationPage = window.location.pathname.match(/\/messages\/\d+/) !== null;
    let lastUnreadCount = 0; // Pour éviter les actualisations inutiles
    let conversationId = null;
    
    // Récupérer l'ID de conversation si on est sur une page de conversation
    if (isConversationPage) {
        const pathParts = window.location.pathname.split('/');
        conversationId = pathParts[pathParts.length - 1];
    }
    
    // Récupérer le dernier ID de message si on est sur une page de messages
    if (isMessagePage) {
        const messageElements = document.querySelectorAll('[data-message-id]');
        if (messageElements.length > 0) {
            const lastElement = messageElements[messageElements.length - 1];
            lastMessageId = parseInt(lastElement.getAttribute('data-message-id') || '0');
        }
    }

    // Fonction pour vérifier les nouveaux messages (optimisée)
    function checkNewMessages() {
        // Construire l'URL avec les paramètres
        let url = '/check-new-messages?last_id=' + lastMessageId;
        
        // Ajouter l'ID de conversation si on est sur une page de conversation
        if (conversationId) {
            url += '&conversation_id=' + conversationId;
        }
        
        // Ajouter un timestamp pour éviter la mise en cache
        url += '&_=' + new Date().getTime();
        
        // Faire la requête avec un timeout pour éviter les blocages
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 3000); // Timeout après 3 secondes
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin',
            signal: controller.signal
        })
        .then(response => response.json())
        .then(data => {
            clearTimeout(timeoutId);
            
            // Mettre à jour les badges de notification seulement si le nombre a changé
            if (data.unread_count !== lastUnreadCount) {
                updateNotificationBadges(data.unread_count);
                lastUnreadCount = data.unread_count;
            }
            
            // Si nous sommes sur une page de messages et qu'il y a de nouveaux messages
            if (isMessagePage && data.has_new_messages) {
                // Actualiser la page seulement si nécessaire
                if (data.last_message_time > lastCheckTime) {
                    window.location.reload();
                }
            }
            
            // Mettre à jour le temps du dernier contrôle
            lastCheckTime = new Date().getTime();
        })
        .catch(error => {
            clearTimeout(timeoutId);
            if (error.name !== 'AbortError') {
                console.error('Erreur lors de la vérification des messages:', error);
            }
        });
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
    
    // Vérifier les messages immédiatement
    checkNewMessages();
    
    // Puis vérifier périodiquement avec un intervalle plus long
    setInterval(checkNewMessages, checkInterval);
});
