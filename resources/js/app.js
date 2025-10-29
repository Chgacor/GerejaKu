import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Listen on the private channel for the logged-in user
// The USER_ID part would be dynamically set by Laravel
window.Echo.private('App.Models.User.' + USER_ID)
    .notification((notification) => {
        console.log('New notification received!', notification);
        // Di sini, panggil fungsi Anda untuk memuat ulang daftar notifikasi
        // Misalnya, jika fungsi fetchNotifications() tersedia secara global:
        if(typeof fetchNotifications === 'function') {
            fetchNotifications();
        }
    });
