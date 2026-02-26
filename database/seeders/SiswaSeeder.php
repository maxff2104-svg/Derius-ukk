<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Seed sample siswa records with user accounts.
     */
    public function run(): void
    {
        $siswaData = [
            ['nis' => '2024001', 'nama' => 'Andi Pratama', 'kelas' => '10A'],
            ['nis' => '2024002', 'nama' => 'Bella Kusuma', 'kelas' => '10A'],
            ['nis' => '2024003', 'nama' => 'Citra Dewi', 'kelas' => '10B'],
            ['nis' => '2024004', 'nama' => 'Doni Saputro', 'kelas' => '10B'],
            ['nis' => '2024005', 'nama' => 'Eka Putri', 'kelas' => '11A'],
        ];

        foreach ($siswaData as $data) {
            // Create user for siswa (use NIS as username)
            $user = User::firstOrCreate(
                ['username' => $data['nis']],
                [
                    'password' => bcrypt($data['nis']),
                    'role' => 'siswa',
                ]
            );

            // Create siswa record linked to user
            Siswa::firstOrCreate(['nis' => $data['nis']], [
                'nama' => $data['nama'],
                'kelas' => $data['kelas'],
                'user_id' => $user->id,
            ]);
        }
    }
}
