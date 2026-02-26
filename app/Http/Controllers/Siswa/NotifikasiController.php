<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of notifications for the logged-in student.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get notifications for the logged-in student only
        $query = Notifikasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        $notifikasi = $query->paginate(10);

        // Count unread notifications
        $unreadCount = Notifikasi::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('siswa.notifikasi.index', compact('notifikasi', 'unreadCount'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Notifikasi $notifikasi)
    {
        // Ensure the notification belongs to the logged-in user
        if ($notifikasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notifikasi->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notifikasi telah dibaca.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $userId = Auth::id();
        
        Notifikasi::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah dibaca.');
    }

    /**
     * Get unread notifications count for AJAX.
     */
    public function getUnreadCount()
    {
        $userId = Auth::id();
        
        $count = Notifikasi::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        // Ensure the notification belongs to the logged-in user
        if ($notifikasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notifikasi->delete();

        return redirect()->back()->with('success', 'Notifikasi telah dihapus.');
    }
}
