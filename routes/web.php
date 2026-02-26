<?php

use Illuminate\Support\Facades\Route;

Route::get('icons', function () {
    return view('pages.icons');
})->name('pages.icons');

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
    }
    return redirect()->route('login');
});

Route::get('/home', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    // Profile routes (both admin and siswa)
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/photo', [App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [App\Http\Controllers\ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Debugging example route for kategori index error
    Route::get('kategori-debug', [App\Http\Controllers\Admin\KategoriController::class, 'debugIndex'])->name('kategori.debug');

    // Aspirasi CRUD
    // ⚠️ Route statis (create, export) HARUS di atas route dinamis {aspirasi}
    Route::get('aspirasi', [App\Http\Controllers\Admin\AspirasiController::class, 'index'])->name('aspirasi.index');
    Route::get('aspirasi/create', [App\Http\Controllers\Admin\AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::get('aspirasi/export', [App\Http\Controllers\Admin\AspirasiController::class, 'export'])->name('aspirasi.export'); // ← dipindah ke sini
    Route::post('aspirasi', [App\Http\Controllers\Admin\AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('aspirasi/{aspirasi}', [App\Http\Controllers\Admin\AspirasiController::class, 'show'])->name('aspirasi.show');
    Route::get('aspirasi/{aspirasi}/edit', [App\Http\Controllers\Admin\AspirasiController::class, 'edit'])->name('aspirasi.edit');
    Route::put('aspirasi/{aspirasi}', [App\Http\Controllers\Admin\AspirasiController::class, 'update'])->name('aspirasi.update');
    Route::delete('aspirasi/{aspirasi}', [App\Http\Controllers\Admin\AspirasiController::class, 'destroy'])->name('aspirasi.destroy');
    Route::put('aspirasi/{aspirasi}/status', [App\Http\Controllers\Admin\AspirasiController::class, 'updateStatus'])->name('aspirasi.status.update');

    // Kategori CRUD
    Route::resource('kategori', App\Http\Controllers\Admin\KategoriController::class)->names('kategori'); // ← hapus tanda ) ekstra

    // Siswa CRUD
    Route::resource('siswa', App\Http\Controllers\Admin\SiswaController::class)->names('siswa'); // ← hapus tanda ) ekstra

    // Activity Log
    Route::get('activity-log', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('activity-log/export', [App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('activity-log.export');

    // User management (admin only)
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names('users');
});

// Siswa routes
Route::prefix('siswa')->name('siswa.')->middleware(['auth','siswa'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('aspirasi', [App\Http\Controllers\Siswa\AspirasiController::class, 'index'])->name('aspirasi.index');
    Route::get('aspirasi/create', [App\Http\Controllers\Siswa\AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('aspirasi', [App\Http\Controllers\Siswa\AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('aspirasi/{aspirasi}', [App\Http\Controllers\Siswa\AspirasiController::class, 'show'])->name('aspirasi.show');
    Route::get('aspirasi/{aspirasi}/edit', [App\Http\Controllers\Siswa\AspirasiController::class, 'edit'])->name('aspirasi.edit');
    Route::put('aspirasi/{aspirasi}', [App\Http\Controllers\Siswa\AspirasiController::class, 'update'])->name('aspirasi.update');
    Route::delete('aspirasi/{aspirasi}', [App\Http\Controllers\Siswa\AspirasiController::class, 'destroy'])->name('aspirasi.destroy');
    
    // Notifikasi
    Route::get('notifikasi', [App\Http\Controllers\Siswa\NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::put('notifikasi/{notifikasi}/read', [App\Http\Controllers\Siswa\NotifikasiController::class, 'markAsRead'])->name('notifikasi.markRead');
    Route::put('notifikasi/mark-all-read', [App\Http\Controllers\Siswa\NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.markAllRead');
    Route::get('notifikasi/unread-count', [App\Http\Controllers\Siswa\NotifikasiController::class, 'getUnreadCount'])->name('notifikasi.unreadCount');
    Route::delete('notifikasi/{notifikasi}', [App\Http\Controllers\Siswa\NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
    
    // Activity Log
    Route::get('activity-log', [App\Http\Controllers\Siswa\ActivityLogController::class, 'index'])->name('activity-log.index');
});