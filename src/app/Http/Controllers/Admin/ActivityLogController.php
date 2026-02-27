<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActivityLogExport;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');
        
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
        
        // Filter by user (only admin can see all logs)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        $activityLogs = $query->paginate(50);
        
        // Get unique model types for filter dropdown
        $modelTypes = ActivityLog::distinct('model_type')->pluck('model_type');
        
        // Get users for filter dropdown (only admin can see all)
        $users = \App\Models\User::where('role', 'admin')->orderBy('username')->get();
        
        return view('admin.activity-log.index', compact('activityLogs', 'modelTypes', 'users'));
    }

    /**
     * Export activity logs to Excel or PDF.
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');
        
        // Apply same filters as index
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        $activityLogs = $query->get();
        
        if ($type === 'pdf') {
            return $this->exportToPDF($activityLogs);
        } else {
            return $this->exportToExcel($activityLogs);
        }
    }

    /**
     * Export to Excel.
     */
    private function exportToExcel($activityLogs)
    {
        $data = $activityLogs->map(function ($log) {
            return [
                'Tanggal' => formatTanggalIndonesia($log->created_at),
                'Waktu' => $log->created_at->format('H:i:s'),
                'User' => $log->user ? $log->user->name : 'System',
                'Model Type' => $log->model_type,
                'Model ID' => $log->model_id,
                'Action' => ucfirst($log->action),
                'Description' => $log->description,
                'IP Address' => $log->ip_address,
            ];
        });

        $title = 'LAPORAN ACTIVITY LOG SISTEM';
        $filename = 'activity_log_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new \App\Exports\FromArrayExport($data->toArray(), $title), $filename);
    }

    /**
     * Export to PDF.
     */
    private function exportToPDF($activityLogs)
    {
        $data = [
            'activityLogs' => $activityLogs,
            'title' => 'Laporan Activity Log',
            'date' => date('d/m/Y H:i:s'),
        ];

        $pdf = PDF::loadView('admin.activity-log.pdf', $data);
        $filename = 'activity_log_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
