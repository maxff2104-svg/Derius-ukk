<?php

namespace App\Providers\ViewComposer;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

/**
 * View composer untuk menyediakan data notifikasi ke semua layout
 */
class NotificationComposer
{
    public function compose($view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $notificationCount = Notifikasi::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
                
            view()->share('notificationCount', $notificationCount);
        } else {
            view()->share('notificationCount', 0);
        }
    }
}
