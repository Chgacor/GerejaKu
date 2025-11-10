<?php

namespace App\Notifications;

// Penting: Sesuaikan path ke model Qna Anda.
// Jika Anda belum membuatnya, path umumnya adalah App\Models\Qna
use App\Models\Qna;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuestionSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Variabel untuk menyimpan data pertanyaan
     */
    public $qna;

    /**
     * Create a new notification instance.
     *
     * Kita akan "menyuntikkan" data pertanyaan ke dalam notifikasi
     * saat notifikasi ini dibuat.
     */
    public function __construct(Qna $qna)
    {
        $this->qna = $qna;
    }

    /**
     * Get the notification's delivery channels.
     *
     * Ini menentukan notifikasi akan dikirim lewat apa.
     * 'mail' = kirim via email
     * 'database' = simpan ke tabel 'notifications' di database
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * Ini adalah fungsi yang mengatur format EMAIL yang akan dikirim.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // $notifiable di sini adalah penerima (admin/jemaat)

        return (new MailMessage)
            ->subject('Ada Pertanyaan Baru: ' . $this->qna->subject)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Seseorang telah mengajukan pertanyaan baru melalui website.')
            ->line('---')
            ->line('**Nama:** ' . $this->qna->name)
            ->line('**Email:** ' . $this->qna->email)
            ->line('**Subjek:** ' . $this->qna->subject)
            ->line('**Pertanyaan:**')
            ->line($this->qna->question)
            ->line('---')
            ->action('Lihat di Admin Panel', url('/admin/qna')); // Ganti URL ini ke panel admin Anda
    }

    /**
     * Get the array representation of the notification (for database).
     *
     * Ini adalah fungsi yang mengatur format data yang disimpan
     * ke tabel 'notifications' di database.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'qna_id' => $this->qna->id,
            'subject' => $this->qna->subject,
            'message' => 'Pertanyaan baru telah diajukan oleh ' . $this->qna->name,
            'url' => url('/admin/qna/' . $this->qna->id), // Link ke detail pertanyaan
        ];
    }
}
