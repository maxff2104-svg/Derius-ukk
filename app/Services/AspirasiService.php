<?php

namespace App\Services;

use App\Models\Aspirasi;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Service layer for Aspirasi (complaint) business logic.
 * Keeps controllers thin and encapsulates creation and status updates.
 */
class AspirasiService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    /**
     * Store a new aspirasi record.
     *
     * @param array $data  Required keys: nis, id_kategori, keterangan, lokasi (optional)
     * @param UploadedFile|null $file Optional uploaded proof image
     * @param User|null $actor User creating the aspirasi (for activity log)
     * @return Aspirasi
     */
    public function storeAspirasi(array $data, ?UploadedFile $file = null, ?User $actor = null): Aspirasi
    {
        return DB::transaction(function () use ($data, $file, $actor) {
            // generate id_pelaporan using helper
            $data['id_pelaporan'] = generateIdPelaporan();

            if ($file instanceof UploadedFile) {
                $path = $file->store('aspirasi', 'public');
                $data['foto_bukti'] = $path;
            }

            $asp = Aspirasi::create([
                'id_pelaporan' => $data['id_pelaporan'],
                'nis' => $data['nis'],
                'id_kategori' => $data['id_kategori'],
                'lokasi' => $data['lokasi'] ?? null,
                'keterangan' => $data['keterangan'],
                'foto_bukti' => $data['foto_bukti'] ?? null,
                'status' => $data['status'] ?? config('aspirasi.status.0'),
                'progres_perbaikan' => $data['progres_perbaikan'] ?? 0,
            ]);

            // log activity
            if ($actor instanceof User) {
                ActivityLog::create([
                    'user_id' => $actor->id,
                    'action' => "Membuat aspirasi: {$asp->id_pelaporan}",
                    'model_type' => Aspirasi::class,
                    'model_id' => $asp->id_aspirasi,
                    'created_at' => now(),
                ]);
            }

            return $asp;
        });
    }

    /**
     * Update status, feedback and progress of an aspirasi.
     *
     * @param Aspirasi $aspirasi
     * @param string $status
     * @param string|null $feedback
     * @param int|null $progress 0-100
     * @param User|null $actor
     * @return Aspirasi
     */
    public function updateStatus(Aspirasi $aspirasi, string $status, ?string $feedback = null, ?int $progress = null, ?User $actor = null): Aspirasi
    {
        return DB::transaction(function () use ($aspirasi, $status, $feedback, $progress, $actor) {
            $old = $aspirasi->status;

            $aspirasi->status = $status;
            if ($feedback !== null) {
                $aspirasi->feedback = $feedback;
            }
            if ($progress !== null) {
                $aspirasi->progres_perbaikan = max(0, min(100, (int) $progress));
            }
            $aspirasi->save();

            // create activity log
            ActivityLog::create([
                'user_id' => $actor?->id ?? null,
                'action' => "Mengubah status aspirasi ({$aspirasi->id_pelaporan}): {$old} => {$status}",
                'model_type' => Aspirasi::class,
                'model_id' => $aspirasi->id_aspirasi,
                'created_at' => now(),
            ]);

            // Send notification to student
            $this->notificationService->notifyAspirasiUpdate($aspirasi, $old);

            // Send notification for feedback if provided
            if ($feedback !== null) {
                $this->notificationService->notifyAspirasiFeedback($aspirasi);
            }

            // Send notification for progress update if provided
            if ($progress !== null) {
                $this->notificationService->notifyProgressUpdate($aspirasi, $aspirasi->progres_perbaikan);
            }

            return $aspirasi;
        });
    }

    /**
     * Remove stored foto_bukti file for an aspirasi (if exists).
     *
     * @param Aspirasi $aspirasi
     * @return void
     */
    public function removeFotoBukti(Aspirasi $aspirasi): void
    {
        if ($aspirasi->foto_bukti && Storage::disk('public')->exists($aspirasi->foto_bukti)) {
            Storage::disk('public')->delete($aspirasi->foto_bukti);
            $aspirasi->foto_bukti = null;
            $aspirasi->save();
        }
    }

    /**
     * Update an existing aspirasi record.
     *
     * @param Aspirasi $aspirasi
     * @param array $data
     * @param UploadedFile|null $file
     * @param User|null $actor
     * @return Aspirasi
     */
    public function updateAspirasi(Aspirasi $aspirasi, array $data, ?UploadedFile $file = null, ?User $actor = null): Aspirasi
    {
        return DB::transaction(function () use ($aspirasi, $data, $file, $actor) {
            // Update fields
            $aspirasi->update([
                'id_kategori' => $data['id_kategori'],
                'lokasi' => $data['lokasi'],
                'keterangan' => $data['keterangan'],
                'nis' => $data['nis'] ?? $aspirasi->nis,
            ]);

            // Update photo if provided
            if ($file instanceof UploadedFile) {
                // Delete old photo
                if ($aspirasi->foto_bukti) {
                    Storage::disk('public')->delete($aspirasi->foto_bukti);
                }
                
                $path = $file->store('aspirasi', 'public');
                $aspirasi->foto_bukti = $path;
                $aspirasi->save();
            }

            // log activity
            if ($actor instanceof User) {
                ActivityLog::create([
                    'user_id' => $actor->id,
                    'action' => "Memperbarui aspirasi: {$aspirasi->id_pelaporan}",
                    'model_type' => Aspirasi::class,
                    'model_id' => $aspirasi->id_aspirasi,
                    'created_at' => now(),
                ]);
            }

            return $aspirasi;
        });
    }

    /**
     * Delete an aspirasi record.
     *
     * @param Aspirasi $aspirasi
     * @param User|null $actor
     * @return bool
     */
    public function deleteAspirasi(Aspirasi $aspirasi, ?User $actor = null): bool
    {
        return DB::transaction(function () use ($aspirasi, $actor) {
            // Delete photo if exists
            if ($aspirasi->foto_bukti) {
                Storage::disk('public')->delete($aspirasi->foto_bukti);
            }

            // log activity before deletion
            if ($actor instanceof User) {
                ActivityLog::create([
                    'user_id' => $actor->id,
                    'action' => "Menghapus aspirasi: {$aspirasi->id_pelaporan}",
                    'model_type' => Aspirasi::class,
                    'model_id' => $aspirasi->id_aspirasi,
                    'created_at' => now(),
                ]);
            }

            return $aspirasi->delete();
        });
    }
}
