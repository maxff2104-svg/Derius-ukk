<?php

namespace App\Services;

use App\Models\Aspirasi;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Create notification for aspirasi status update.
     */
    public function notifyAspirasiUpdate(Aspirasi $aspirasi, $oldStatus = null)
    {
        // Get the student who created the aspiration
        $student = $aspirasi->siswa;
        
        if (!$student || !$student->user_id) {
            return;
        }

        // Create notification message based on status change
        $message = $this->getNotificationMessage($aspirasi->status, $oldStatus);
        $type = $this->getNotificationType($aspirasi->status);

        Notifikasi::create([
            'user_id' => $student->user_id,
            'aspirasi_id' => $aspirasi->id_aspirasi,
            'judul' => 'Status Aspirasi Diperbarui',
            'pesan' => $message,
            'tipe' => $type,
            'is_read' => false,
        ]);
    }

    /**
     * Create notification for aspirasi feedback.
     */
    public function notifyAspirasiFeedback(Aspirasi $aspirasi)
    {
        $student = $aspirasi->siswa;
        
        if (!$student || !$student->user_id) {
            return;
        }

        $feedbackText = $aspirasi->feedback ? $aspirasi->feedback : 'Tidak ada feedback';

        Notifikasi::create([
            'user_id' => $student->user_id,
            'aspirasi_id' => $aspirasi->id_aspirasi,
            'judul' => 'Feedback Diberikan',
            'pesan' => "Aspirasi Anda (ID: {$aspirasi->id_pelaporan}) telah diberikan feedback: " . $feedbackText,
            'tipe' => 'info',
            'is_read' => false,
        ]);
    }

    /**
     * Create notification for progress update.
     */
    public function notifyProgressUpdate(Aspirasi $aspirasi, $oldProgress = null)
    {
        $student = $aspirasi->siswa;
        
        if (!$student || !$student->user_id) {
            return;
        }

        Notifikasi::create([
            'user_id' => $student->user_id,
            'aspirasi_id' => $aspirasi->id_aspirasi,
            'judul' => 'Progress Perbaikan Diperbarui',
            'pesan' => "Aspirasi Anda (ID: {$aspirasi->id_pelaporan}) progress perbaikan diperbarui menjadi {$aspirasi->progres_perbaikan}%",
            'tipe' => 'info',
            'is_read' => false,
        ]);
    }

    /**
     * Get notification message based on status.
     */
    private function getNotificationMessage($newStatus, $oldStatus = null)
    {
        $messages = [
            'Menunggu' => 'Aspirasi Anda sedang dalam antrian dan menunggu proses.',
            'Diproses' => 'Aspirasi Anda sedang diproses oleh tim terkait.',
            'Selesai' => 'Aspirasi Anda telah selesai diperbaiki. Terima kasih atas pengaduannya!',
            'Ditolak' => 'Aspirasi Anda ditolak. Silakan periksa kembali pengajuan Anda.',
        ];

        if ($oldStatus && $oldStatus !== $newStatus) {
            $statusMessage = isset($messages[$newStatus]) ? $messages[$newStatus] : '';
            return "Status aspirasi Anda berubah dari '{$oldStatus}' menjadi '{$newStatus}'. {$statusMessage}";
        }

        return isset($messages[$newStatus]) ? $messages[$newStatus] : 'Status aspirasi Anda telah diperbarui.';
    }

    /**
     * Get notification type based on status.
     */
    private function getNotificationType($status)
    {
        $types = [
            'Menunggu' => 'warning',
            'Diproses' => 'info',
            'Selesai' => 'success',
            'Ditolak' => 'danger',
        ];

        return isset($types[$status]) ? $types[$status] : 'info';
    }

    /**
     * Get unread notifications count for user.
     */
    public function getUnreadCount($userId)
    {
        return Notifikasi::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Mark notifications as read for user.
     */
    public function markAsRead($userId, $notificationIds = [])
    {
        $query = Notifikasi::where('user_id', $userId)->where('is_read', false);
        
        if (!empty($notificationIds)) {
            $query->whereIn('id', $notificationIds);
        }
        
        return $query->update(['is_read' => true]);
    }
}
