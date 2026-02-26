<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Seed default categories from config.
     */
    public function run(): void
    {
        $categories = config('aspirasi.kategori_default', [
            'Toilet',
            'Laboratorium',
            'Perpustakaan',
            'Lapangan',
            'Kantin',
            'Kelas',
        ]);

        foreach ($categories as $kategori) {
            Kategori::firstOrCreate(['ket_kategori' => $kategori]);
        }
    }
}
