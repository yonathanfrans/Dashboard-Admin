<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Helpers\Hashid;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\Faq;
use App\Models\FaqMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faqs = Faq::with('faqMenu')
            ->when($request->filled('search'), function ($query) use ($request) {
                // Filter search pertanyaan atau jawaban
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('pertanyaan', 'like', "%{$search}%")
                        ->orWhere('jawaban', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('id_sub'), function ($query) use ($request){
                // Filter Menu / Submenu
                $realIdSub = Hashid::decode($request->id_sub);

                // Kalau berhasil decode hash ID
                if ($realIdSub) {
                    $query->where('id_sub', $realIdSub);
                }
            })
            ->when($request->filled('jenis'), function ($query) use ($request) {
                // Filter jenis
                $query->where('jenis', $request->jenis);
            })
            ->when($request->filled('publish'), function ($query) use ($request) {
                // Filter status
                $query->where('publish', $request->publish);
            })
            ->latest('created')
            ->paginate(10)
            ->withQueryString();
        
        // Ambil data FAQ Menu
        $menus = FaqMenu::where('aktif', 'Y')
            ->orderBy('menu')
            ->orderBy('no_urut')
            ->get();

        return view('faq.index', compact('faqs', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data FAQ Menu
        $menus = FaqMenu::where('aktif', 'Y')
            ->orderBy('menu')
            ->orderBy('no_urut')
            ->get();
        
        return view('faq.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request)
    {
        // Validasi request form
        $validated = $request->validated();

        // Handle file upload jika jenis = pdf & pastikan jawaban null
        if ($request->jenis === 'pdf' && $request->hasFile('link')) {
            $validated['link'] = $request->file('link')->store('faq_pdf', 'public');
            $validated['jawaban'] = null; 
        } else {
            // pastikan link null jika jenis = Menu
            $validated['link'] = null;
        }

        // field otomatis
        $validated['note'] = null;
        $validated['created'] = now();
        $validated['counter'] = 0;
        $validated['user_id'] = null;

        // Simpan ke db
        Faq::create($validated);

        // Catat log create
        ActivityLogger::log('Menambahkan FAQ baru: ' . $validated['pertanyaan']);

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil ditambahkan!');
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
    public function edit(Faq $faq)
    {
        // Ambil data FAQ Menu
        $menus = FaqMenu::where('aktif', 'Y')
            ->orderBy('menu')
            ->orderBy('no_urut')
            ->get();

        return view('faq.update', compact('faq', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        // Validasi request form 
        $validated = $request->validated();

        if ($request->jenis === 'pdf') {
            $validated['jawaban'] = null;

            if ($request->hasFile('link')) {
                // simpan path file lama 
                $oldFile = $faq->link;

                // simpan file baru 
                $validated['link'] = $request->file('link')->store('faq_pdf', 'public');

                // Hapus PDF lama dari storage
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            } else {
                // Tetap pakai link lama jika tidak upload baru
                $validated['link'] = $faq->link;
            }
        } else {
            // Jika berubah jenis ke Menu, hapus file lama jika ada
            if ($faq->link && Storage::disk('public')->exists($faq->link)) {
                Storage::disk('public')->delete($faq->link);
            }
            $validated['link'] = null;
        }

        // Update data FAQ
        $faq->update($validated);

        // Catat log update
        ActivityLogger::log('Memperbarui FAQ: ' . $validated['pertanyaan']);

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        // Simpan path file lama sebelum dihapus
        $oldFile = $faq->link;

        try {
            DB::transaction(function() use ($faq) {
                $faq->delete();
            });

            // Catat log delete
            ActivityLogger::log('Menghapus FAQ: ' . $faq->pertanyaan);

            // Hapus file dari storage
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
            
            return redirect()->back()->with('success', 'FAQ berhasil dihapus!');
        } catch (\Throwable $e) {
            // Error message ke log server
            Log::error('Gagal menghapus FAQ ID ' . $faq->id . ": " . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus FAQ. Silahkan coba lagi.');
        }
    }
}
