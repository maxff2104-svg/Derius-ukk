<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'user_id',
    ];

    /**
     * Relation: siswa belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: siswa has many aspirasi
     */
    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'nis', 'nis');
    }

    /**
     * Get the aspirasi count for this student
     */
    public function getAspirasiCountAttribute(): int
    {
        return $this->aspirasi()->count();
    }

    /**
     * Get the pending aspirasi count for this student
     */
    public function getPendingAspirasiCountAttribute(): int
    {
        return $this->aspirasi()->where('status', 'Menunggu')->count();
    }
}
