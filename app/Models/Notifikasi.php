<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasis';
    
    protected $fillable = [
        'user_id',
        'aspirasi_id',
        'judul',
        'pesan',
        'tipe',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the aspirasi related to this notification.
     */
    public function aspirasi(): BelongsTo
    {
        return $this->belongsTo(Aspirasi::class, 'aspirasi_id', 'id_aspirasi');
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): bool
    {
        return $this->update(['is_read' => true]);
    }

    /**
     * Get formatted notification type for display.
     */
    public function getFormattedTypeAttribute(): string
    {
        $types = [
            'success' => 'success',
            'danger' => 'danger',
            'warning' => 'warning',
            'info' => 'info',
        ];

        return $types[$this->tipe] ?? 'info';
    }

    /**
     * Get the notification badge class.
     */
    public function getBadgeClassAttribute(): string
    {
        $classes = [
            'success' => 'badge-success',
            'danger' => 'badge-danger',
            'warning' => 'badge-warning',
            'info' => 'badge-info',
        ];

        return $classes[$this->tipe] ?? 'badge-info';
    }
}
