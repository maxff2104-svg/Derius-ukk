<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }
        
        $activityLogs = $query->paginate(20);
        
        // Get unique model types for filter dropdown (only user's activities)
        $modelTypes = ActivityLog::where('user_id', auth()->id())
            ->distinct('model_type')
            ->pluck('model_type');
        
        return view('siswa.activity-log.index', compact('activityLogs', 'modelTypes'));
    }
}
