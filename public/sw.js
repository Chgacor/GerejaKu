'use strict';

self.addEventListener('push', function (event) {
    const data = event.data.json();
    const options = {
        body: data.body,
        icon: data.icon,
        // Tambahkan URL ke data agar bisa dibuka saat notif di-klik
        data: {
            url: data.data.url
        }
    };
    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

// Event listener untuk saat notifikasi di-klik
self.addEventListener('notificationclick', function (event) {
    // Tutup notifikasi
    event.notification.close();

    // Buka URL yang ada di data notifikasi
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
