<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackingSiup;

class TrackingSiupController extends Controller
{
    public function index(Request $request)
    {
        $hasSearch = $request->filled('search');

        if ($hasSearch) {
            $trackingLists = TrackingSiup::query()
                // Filter pencarian teks
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->search;
                    $query->where(function ($query) use ($search) {
                        $query->where('nama_pemilik', 'like', "%{$search}%")
                            ->orWhere('nomor_agenda', 'like', "%{$search}%")
                            ->orWhere('id_permohonan_izin', 'like', "%{$search}%")
                            ->orWhere('nomor_izin', 'like', "%{$search}%");
                    });
                })
                // Filter status izin
                // ->when($request->filled('nama_status_izin'), function ($query) use ($request) {
                //     $query->where('nama_status_izin', $request->nama_status_izin);
                // })
                // Filter status terbit
                // ->when($request->filled('status_terbit'), function ($query) use ($request) {
                //     $query->where('status_terbit', $request->status_terbit);
                // })
                ->latest('tanggal_permohonan')
                ->paginate(10)
                ->withQueryString();
        } else {
            // Jika belum ada pencarian, kembalikan paginator kosong
            $trackingLists = TrackingSiup::whereRaw('1 = 0')->paginate(10);
        }

        return view('trackingSiup.index', compact('trackingLists', 'hasSearch'));
    }
}