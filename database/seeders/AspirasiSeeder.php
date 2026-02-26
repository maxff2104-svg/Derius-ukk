<?php

namespace Database\Seeders;

use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    /**
     * Seed sample aspirasi records with various statuses.
     */
    public function run(): void
    {
        $siswa = Siswa::all();
        $kategori = Kategori::all();

        if ($siswa->isEmpty() || $kategori->isEmpty()) {
            $this->command->error('Run SiswaSeeder and KategoriSeeder first!');
            return;
        }

        $aspirasi = [
            [
                'nis' => $siswa[0]->nis,
                'id_kategori' => $kategori[0]->id_kategori,
                'lokasi' => 'Toilet Dekat Kelas 10A',
                'keterangan' => 'Kamar mandi toilet ada yang mampet, mohon segera diperbaiki.',
                'status' => 'Menunggu',
                'progres_perbaikan' => 0,
            ],
            [
                'nis' => $siswa[1]->nis,
                'id_kategori' => $kategori[1]->id_kategori,
                'lokasi' => 'Lab Komputer',
                'keterangan' => 'Beberapa komputer di lab sudah rusak dan perlu diganti.',
                'status' => 'Diproses',
                'progres_perbaikan' => 50,
            ],
            [
                'nis' => $siswa[2]->nis,
                'id_kategori' => $kategori[2]->id_kategori,
                'lokasi' => 'Perpustakaan Lantai 1',
                'keterangan' => 'Rak buku sudah tua dan tidak stabil, takut roboh.',
                'status' => 'Selesai',
                'progres_perbaikan' => 100,
            ],
            [
                'nis' => $siswa[3]->nis,
                'id_kategori' => $kategori[3]->id_kategori,
                'lokasi' => 'Lapangan Olahraga',
                'keterangan' => 'Rerumputan lapangan sudah mati, tidak bisa digunakan.',
                'status' => 'Ditolak',
                'progres_perbaikan' => 0,
            ],
            [
                'nis' => $siswa[4]->nis,
                'id_kategori' => $kategori[4]->id_kategori,
                'lokasi' => 'Kantin',
                'keterangan' => 'Meja dan kursi di kantin banyak yang rusak.',
                'status' => 'Menunggu',
                'progres_perbaikan' => 0,
            ],
        ];

        foreach ($aspirasi as $item) {
            $item['id_pelaporan'] = generateIdPelaporan();
            Aspirasi::create($item);
        }
    }
}
