<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $activityLogs = ActivityLog::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                // Filter pencarian nama, email, atau deskripsi
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            // Filter rentang tanggal (Date Range)
            ->when($request->filled('date_range'), function ($query) use ($request) {
                $dates = explode(' to ', $request->date_range);

                if (count($dates) === 2) {
                    // Jika pengguna memilih rentang tanggal (Start Date & End Date)
                    $startDate = trim($dates[0]) . ' 00:00:00';
                    $endDate   = trim($dates[1]) . ' 23:59:59';

                    $query->whereBetween('date_created', [$startDate, $endDate]);
                } elseif (count($dates) === 1) {
                    // Jika pengguna hanya memilih 1 tanggal tunggal
                    $query->whereDate('date_created', trim($dates[0]));
                }
            })
            ->latest('date_created')
            ->paginate(10)
            ->withQueryString();

        return view('activityLog.index', compact('activityLogs'));
    }
}
