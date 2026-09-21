<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessRequest;
use App\Http\Requests\UpdateAccessRequest;
use App\Models\AccessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AccessRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $accessRequests = AccessRequest::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                // Filter pencarian nama / email / unit_kerja
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('unit_kerja', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('jns_permintaan'), function ($query) use ($request) {
                // Filter jenis permintaan
                $query->where('jns_permintaan', $request->jns_permintaan);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                // Filter status
                $query->where('status', $request->status);
            })
            ->when($request->filled('aktif'), function ($query) use ($request) {
                // Filter aktif
                $query->where('aktif', $request->aktif);
            }) 
            ->latest('date_created')
            ->paginate(10)
            ->withQueryString();

        return view('accessRequest.index', compact('accessRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accessRequest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccessRequest $request)
    {
        // validasi request form
        $validated = $request->validated();

        // Handle file form akses
        $validated['url_form_akses'] = $request->file('url_form_akses')->store('formAccess_pdf', 'public');

        // Field otomatis
        $validated['status'] = 'pending';
        $validated['aktif'] = 'T';

        // Simpan ke db
        AccessRequest::create($validated);

        return redirect()->route('accessRequest.index')->with('success', 'Permohonan hak akses berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccessRequest $accessRequest)
    {
        return view('accessRequest.update', compact('accessRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccessRequest $request, AccessRequest $accessRequest)
    {
        // Validasi request form
        $validated = $request->validated();

        // Handle file form jika file diupdate
        if ($request->hasFile('url_form_akses')) {
            // simpan path file lama
            $oldFile = $accessRequest->url_form_akses;

            // simpan file baru
            $validated['url_form_akses'] = $request->file('url_form_akses')->store('formAccess_pdf', 'public');

            // Hapus file lama dari storage
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        } else {
            $validated['url_form_akses'] = $accessRequest->url_form_akses;
        }

        // Otomatis update field aktif jika status berubah
        // $validated['aktif'] = $validated['status'] === 'approved' ? 'Y' : 'T';

        // Update data permohonan hak akses
        $accessRequest->update($validated);

        return redirect()->route('accessRequest.index')->with('success', 'Permohonan hak akses berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccessRequest $accessRequest)
    {
        // Simpan path file lama sebelum dihapus
        $oldFile = $accessRequest->url_form_akses;

        try {
            DB::transaction(function() use ($accessRequest) {
                $accessRequest->delete();
            });

            // Hapus file dari storage
            if  ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            return redirect()->route('accessRequest.index')->with('success', 'Permohonan hak akses berhasil dihapus!');
        } catch (\Throwable $e) {
            // Error message ke log server
            Log::error('Gagal menghapus permohonan hak akses ID ' . $accessRequest->id . ": " . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus permohonan hak akses. Silahkan coba lagi.');
        }
    }
}
