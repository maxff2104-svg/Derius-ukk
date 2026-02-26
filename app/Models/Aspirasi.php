<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';
    protected $primaryKey = 'id_aspirasi';

    protected $fillable = [
        'id_pelaporan',
        'nis',
        'id_kategori',
        'lokasi',
        'keterangan',
        'foto_bukti',
        'status',
        'feedback',
        'progres_perbaikan',
    ];

    /**
     * Relation: aspirasi belongs to siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    /**
     * Relation: aspirasi belongs to kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Get the status badge HTML
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'Menunggu' => 'warning',
            'Diproses' => 'info',
            'Selesai' => 'success',
            'Ditolak' => 'danger',
        ];

        $color = $colors[$this->status] ?? 'secondary';
        return "<span class='badge badge-{$color}'>{$this->status}</span>";
    }

    /**
     * Get the foto bukti URL
     */
    public function getFotoBuktiUrlAttribute(): string
    {
        if ($this->foto_bukti) {
            return asset('storage/' . $this->foto_bukti);
        }
        
        return asset('images/no-image.png');
    }

    /**
     * Check if aspirasi is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'Selesai';
    }

    /**
     * Check if aspirasi is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'Menunggu';
    }

    /**
     * Check if aspirasi is being processed
     */
    public function isProcessing(): bool
    {
        return $this->status === 'Diproses';
    }

    /**
     * Check if aspirasi is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'Ditolak';
    }
}
