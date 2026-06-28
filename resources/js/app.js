import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Inicialización de Laravel Echo con Reverb
if (import.meta.env.VITE_REVERB_APP_KEY) {
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
        wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
        wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
        enabledTransports: ['ws', 'wss'],
    });

    // Escuchar notificaciones en el canal público
    window.Echo.channel('comunidad')
        .listen('.resource.created', (e) => {
            console.log('Evento real-time recibido:', e);
            addNotification(e);
        });
}

// --- Gestión de Notificaciones ---

function getNotifications() {
    try {
        return JSON.parse(localStorage.getItem('user_notifications')) || [];
    } catch {
        return [];
    }
}

function saveNotifications(notifications) {
    localStorage.setItem('user_notifications', JSON.stringify(notifications));
}

function addNotification(eventData) {
    const notifications = getNotifications();
    
    // Agregar al principio de la lista
    notifications.unshift({
        id: Date.now() + Math.random().toString(36).substr(2, 5),
        type: eventData.type,
        title: eventData.title,
        url: eventData.url,
        read: false,
        created_at: new Date().toISOString()
    });

    // Mantener un límite de 20 notificaciones
    if (notifications.length > 20) {
        notifications.pop();
    }

    saveNotifications(notifications);
    renderNotifications();
}

function renderNotifications() {
    const notifications = getNotifications();
    const unread = notifications.filter(n => !n.read);

    // Badges en Desktop y Mobile
    const desktopBadge = document.getElementById('notifications-badge');
    const mobileBadge = document.getElementById('mobile-notifications-badge');

    if (desktopBadge) {
        if (unread.length > 0) {
            desktopBadge.classList.remove('hidden');
        } else {
            desktopBadge.classList.add('hidden');
        }
    }

    if (mobileBadge) {
        if (unread.length > 0) {
            mobileBadge.classList.remove('hidden');
        } else {
            mobileBadge.classList.add('hidden');
        }
    }

    // Listado Desktop
    const listContainer = document.getElementById('notifications-list');
    if (listContainer) {
        if (notifications.length === 0) {
            listContainer.innerHTML = `
                <div class="px-4 py-6 text-center text-stone-400 text-xs">
                    🕊️ No tienes notificaciones
                </div>
            `;
        } else {
            listContainer.innerHTML = notifications.map(n => `
                <div class="px-4 py-3 hover:bg-stone-50 transition-colors flex items-start justify-between gap-2 border-b border-stone-50 last:border-0 ${!n.read ? 'bg-amber-50/20' : ''}">
                    <a href="${n.url}" data-id="${n.id}" class="notification-link flex-1 text-[11px] leading-relaxed text-stone-700 hover:text-amber-900">
                        <span class="font-bold uppercase text-[9px] text-amber-900 block mb-0.5">
                            ${n.type === 'post' ? '📖 Devocional' : n.type === 'testimonial' ? '✨ Testimonio' : '🙏 Oración'}
                        </span>
                        ${n.title}
                    </a>
                    <button data-id="${n.id}" class="delete-notification-btn text-stone-400 hover:text-stone-750 text-xs px-1">&times;</button>
                </div>
            `).join('');
            
            // Asignar listeners a los enlaces de notificación
            document.querySelectorAll('.notification-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    markAsRead(link.getAttribute('data-id'));
                });
            });

            // Asignar listeners a los botones de borrar individual
            document.querySelectorAll('.delete-notification-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    deleteNotification(btn.getAttribute('data-id'));
                });
            });
        }
    }

    // Listado Mobile
    const mobileListContainer = document.getElementById('mobile-notifications-list-container');
    if (mobileListContainer) {
        if (notifications.length === 0) {
            mobileListContainer.innerHTML = `
                <div class="py-2 text-stone-400 text-xs italic">
                    Sin notificaciones
                </div>
            `;
        } else {
            mobileListContainer.innerHTML = notifications.map(n => `
                <div class="py-2 flex items-center justify-between gap-2 border-b border-stone-100/50 last:border-0">
                    <a href="${n.url}" data-id="${n.id}" class="notification-link flex-1 hover:text-amber-900 ${!n.read ? 'font-medium text-stone-900' : ''}">
                        [${n.type === 'post' ? 'Devocional' : n.type === 'testimonial' ? 'Testimonio' : 'Oración'}] ${n.title}
                    </a>
                </div>
            `).join('');

            document.querySelectorAll('#mobile-notifications-list-container .notification-link').forEach(link => {
                link.addEventListener('click', () => {
                    markAsRead(link.getAttribute('data-id'));
                });
            });
        }
    }
}

function markAsRead(id) {
    const notifications = getNotifications();
    const index = notifications.findIndex(n => n.id === id);
    if (index !== -1) {
        notifications[index].read = true;
        saveNotifications(notifications);
        renderNotifications();
    }
}

function deleteNotification(id) {
    let notifications = getNotifications();
    notifications = notifications.filter(n => n.id !== id);
    saveNotifications(notifications);
    renderNotifications();
}

// Inicializar en el DOM
document.addEventListener('DOMContentLoaded', () => {
    renderNotifications();

    // Toggle Dropdown Desktop
    const btn = document.getElementById('notifications-btn');
    const dropdown = document.getElementById('notifications-dropdown');
    
    if (btn && dropdown) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });
        
        // Cerrar dropdown al hacer click afuera
        document.addEventListener('click', () => {
            dropdown.classList.add('hidden');
        });
        
        dropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    // Toggle User Dropdown Desktop
    const userBtn = document.getElementById('user-menu-btn');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userBtn && userDropdown) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (dropdown) dropdown.classList.add('hidden');
            userDropdown.classList.toggle('hidden');
        });
        
        document.addEventListener('click', () => {
            userDropdown.classList.add('hidden');
        });
        
        userDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    // Toggle Dropdown Mobile
    const mobileBtn = document.getElementById('mobile-notifications-btn');
    const mobileList = document.getElementById('mobile-notifications-list-container');
    if (mobileBtn && mobileList) {
        mobileBtn.addEventListener('click', () => {
            mobileList.classList.toggle('hidden');
        });
    }

    // Limpiar todo
    const clearBtn = document.getElementById('clear-notifications-btn');
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            const notifications = getNotifications();
            notifications.forEach(n => n.read = true);
            saveNotifications(notifications);
            renderNotifications();
        });
    }
});
