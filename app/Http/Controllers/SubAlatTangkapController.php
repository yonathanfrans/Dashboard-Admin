<?php

namespace App\Http\Controllers;

use App\Models\SubAlatTangkap;
use Illuminate\Http\Request;

class SubAlatTangkapController extends Controller
{
    public function index(Request $request)
    {
        $subAlatTangkapList = SubAlatTangkap::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($query) use ($search) {
                    $query->where('keterangan', 'like', "%{$search}%")
                        ->orWhere('kelompok_alat_tangkap', 'like', "%{$search}%")
                        ->orWhere('alat_tangkap_pnbp', 'like', "%{$search}%")
                        ->orWhere('kode_alat_tangkap', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('aktif'), function ($query) use ($request) {
                $query->whereRaw(
                    'FIND_IN_SET(?, aktif)', 
                    [$request->aktif]
                );
            })
            ->when($request->filled('kelompok_alat_tangkap'), function ($query) use ($request) {
                $query->whereRaw(
                    'FIND_IN_SET(?, kelompok_alat_tangkap)',
                    [$request->kelompok_alat_tangkap]
                );
            })
            ->orderBy('id_sub_alat_tangkap')
            ->paginate(10)
            ->withQueryString();

        return view('subAlatTangkap.index', compact('subAlatTangkapList'));
    }
}
