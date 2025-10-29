<?php
// Lokasi: app/Notifications/NewContentNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewContentNotification extends Notification
{
    use Queueable;

    public $data;

    public function __construct(string $title, string $body, string $url, string $type)
    {
        $this->data = [
            'title' => $title, 'body' => $body, 'url' => $url, 'type' => $type,
            'icon' => '/images/icon.png'
        ];
    }

    /**
     * Tentukan channel (DATABASE & BROADCAST)
     */
    public function via(object $notifiable): array
    {
        // [PERUBAHAN] Ditambahkan 'broadcast' agar notifikasi dikirim real-time
        return ['database', 'broadcast'];
    }

    /**
     * Data yang disimpan ke database
     */
    public function toDatabase(object $notifiable): array
    {
        // Ini tetap sama
        return $this->data;
    }

    /**
     * Data array (opsional)
     */
    public function toArray(object $notifiable): array
    {
        // Ini tetap sama
        return $this->data;
    }

    /**
     * [PERUBAHAN] Metode baru untuk data yang akan di-broadcast
     * Data yang dikirim via broadcast (real-time)
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        // Kita kirim data yang sama dengan yang disimpan di database
        // Frontend (Laravel Echo) akan menerima objek ini
        return new BroadcastMessage($this->data);
    }
}
