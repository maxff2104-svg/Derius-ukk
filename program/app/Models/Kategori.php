<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'ket_kategori',
    ];

    /**
     * Relation: kategori has many aspirasi
     */
    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Get the aspirasi count for this category
     */
    public function getAspirasiCountAttribute(): int
    {
        return $this->aspirasi()->count();
    }

    /**
     * Get the pending aspirasi count for this category
     */
    public function getPendingAspirasiCountAttribute(): int
    {
        return $this->aspirasi()->where('status', 'Menunggu')->count();
    }

    /**
     * Get the completed aspirasi count for this category
     */
    public function getCompletedAspirasiCountAttribute(): int
    {
        return $this->aspirasi()->where('status', 'Selesai')->count();
    }
}
