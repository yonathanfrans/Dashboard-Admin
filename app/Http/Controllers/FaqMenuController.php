<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Http\Requests\StoreFaqMenuRequest;
use App\Http\Requests\UpdateFaqMenuRequest;
use App\Models\FaqMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FaqMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil daftar menu yang unik
        $existingMenus = FaqMenu::distinct()->pluck('menu');

        $faqMenus = FaqMenu::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                // Filter pencarian menu atau sub_menu
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('menu', 'like', "%{$search}%")
                        ->orWhere('sub_menu', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('menu'), function ($query) use ($request) {
                // Filter menu
                $query->where('menu', $request->menu);
            })
            ->orderBy('menu')
            ->orderBy('no_urut')
            ->paginate(10)  
            ->withQueryString();   
        
        return view('faq.menu', compact('faqMenus', 'existingMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqMenuRequest $request)
    {
        // Validasi request form 
        $validated = $request->validated();
        
        // Auto Increment id_sub manual
        $lastIdSub = FaqMenu::max('id_sub') ?? 0; 
        $validated['id_sub'] = $lastIdSub + 1;

        // Auto Increment no_urut berdasarkan menu yang dipilih
        $lastNoUrut = FaqMenu::where('menu', $validated['menu'])->max('no_urut') ?? 0;
        $validated['no_urut'] = $lastNoUrut + 1;

        // Simpan data ke db
        FaqMenu::create($validated);

        // Catat log create
        ActivityLogger::log('Menambahkan kategori FAQ baru: ' . $validated['menu'] . ' - ' . $validated['sub_menu']);

        return redirect()->back()->with('success', 'Kategori FAQ berhasil ditambahkan!');
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
    public function edit(FaqMenu $faqMenu)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqMenuRequest $request, FaqMenu $faqMenu)
    {
        $validated = $request->validated();

        // Simpan menu lama dan no_urut lama sebelum terupdate
        $oldMenu = $faqMenu->menu;
        $oldNoUrut = $faqMenu->no_urut;

        // Simpan menu baru dan no_urut baru sebelum terupdate
        $newMenu = $validated['menu'];
        $newNoUrut = (int) $validated['no_urut'];

        // Jika menu berubah, update no_urut berdasarkan menu yang baru
        DB::transaction(function () use ($faqMenu, $validated, $oldMenu, $oldNoUrut, $newMenu, $newNoUrut) {
            // Jika menu tidak berubah, hanya posisi no_urut yang berubah
            if ($oldMenu === $newMenu) {
                // Kalau no urut baru < no urut lama, geser naik (increment) no_urut
                if ($newNoUrut < $oldNoUrut) {
                    FaqMenu::where('menu', $oldMenu)
                        ->where('id_sub', '!=', $faqMenu->id_sub)
                        ->whereBetween('no_urut', [$newNoUrut, $oldNoUrut - 1])
                        ->increment('no_urut');
                } elseif ($newNoUrut > $oldNoUrut) {
                    // Kalau no urut baru > no urut lama, geser turun (decrement) no_urut
                    FaqMenu::where('menu', $oldMenu)
                        ->where('id_sub', '!=', $faqMenu->id_sub)
                        ->whereBetween('no_urut', [$oldNoUrut + 1, $newNoUrut])
                        ->decrement('no_urut');
                }
            } else {
                // Jika pindah menu baru, Rapihkan urutan di menu lama (geser turun semua item)
                FaqMenu::where('menu', $oldMenu)
                    ->where('no_urut', '>', $newNoUrut)
                    ->decrement('no_urut');
                
                // geser urutan menu baru jika disisipkan di tengah
                FaqMenu::where('menu', $newMenu)
                    ->where('no_urut', '>=', $newNoUrut)
                    ->increment('no_urut');
            }
    
            // Update data ke db
            $faqMenu->update($validated);

            // Catat log update
            ActivityLogger::log('Memperbarui kategori FAQ: ' . $validated['menu'] . ' - ' . $validated['sub_menu']);

        });

        return redirect()->back()->with('success', 'Kategori FAQ berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqMenu $faqMenu)
    {
        $menu = $faqMenu->menu;
        $noUrut = $faqMenu->no_urut;

        // Tolak penghapusan jika masih ada pertanyaan terkait dengan kategori
        if ($faqMenu->faqs()->exists()) {
            return redirect()->back()->with('error', 'Kategori ' . $menu . ' tidak dapat dihapus karena masih memiliki pertanyaan terkait!');
        }

        try {
            DB::transaction(function () use ($faqMenu, $menu, $noUrut) {
                // Hapus kategori FAQ
                $faqMenu->delete();
        
                // Rapihkan kembali no_urut item sisanya
                FaqMenu::where('menu', $menu)
                    ->where('no_urut', '>', $noUrut)
                    ->decrement('no_urut');
            });

            // Catat log delete
            ActivityLogger::log('Menghapus kategori FAQ: ' . $faqMenu->menu . ' - ' . $faqMenu->sub_menu);
    
            return redirect()->back()->with('success', 'Kategori FAQ berhasil dihapus!');

        } catch (\Throwable $e) {
            // Error message ke log server
            Log::error('Gagal menghapus kategori FAQ ID ' . $faqMenu->id_sub . ": " . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori FAQ. Silahkan coba lagi.');
        }

    }
}
