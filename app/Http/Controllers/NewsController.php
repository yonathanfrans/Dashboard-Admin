<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $news = News::query() 
            ->when($request->filled('search'), function ($query) use ($request) {
                // Filter pencarian judul atau konten
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('heading', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('flag_kegiatan'), function ($query) use ($request) {
                // Filter kategori
                $query->where('flag_kegiatan', $request->flag_kegiatan);
            })
            ->when($request->filled('publish'), function ($query) use ($request) {
                // Filter status
                $query->where('publish', $request->publish);
            })
            ->latest('entry_date') // Urutkan berdasarkan berita yang baru dibuat
            ->paginate(10)          // Pagination 10 data per halaman
            ->withQueryString();     // Menyimpan parameter URL saat pindah halaman pagination

        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        // Validasi request form
        $validated = $request->validated();

        // generate slug
        $baseSlug = Str::slug($validated['heading']);
        $slug = $baseSlug;
        $count = 1;

        // Jika request slug == db slug
        while (News::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }
        $validated['slug'] = $slug;

        // Store thumbnail ke folder
        $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('news/thumbnails', 'public');

        // Store large image ke folder & jenis file
        $validated['large_image'] = $request->file('large_image')->store('news/large_images', 'public');
        $extension = strtolower($request->file('large_image')->getClientOriginalExtension());
        $validated['jns_file'] = match ($extension) {
            'jpg', 'jpeg', 'png' => 'image',
            'pdf' => 'pdf',
            default => null,
        };
        
        // field date_news otomatis terisi
        $validated['date_news'] = now()->toDateString();
        // field show_since otomatis terisi jika publish = Y
        $validated['show_since'] = $validated['publish'] === 'Y' ? now()->toDateString() : null;

        // field otomatis
        $validated['off_from'] = null;
        $validated['video_url'] = null;
        $validated['video_url_smaller'] = null;
        $validated['counter'] = 0;
        $validated['id_user'] = null;

        // Simpan ke db
        News::create($validated);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news.update', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        // Validasi request form 
        $validated = $request->validated();

        // Update slug jika title berubah
        if ($validated['heading'] !== $news->heading) {
            $baseSlug = Str::slug($validated['heading']);
            $slug = $baseSlug;
            $count = 1;

            // Cek slug ke db, abaikan id berita agar tidak bentrok
            while (News::where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        // Jika ada upload file thumbnail image
        if ($request->hasFile('thumbnail_image')) {
            // Simpan path file thumbnail lama
            $oldThumbnail = $news->thumbnail_image;

            // simpan thumbnail baru
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('news/thumbnails', 'public');

            // hapus thumbnail lama dari storage 
            if ($oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
                Storage::disk('public')->delete($oldThumbnail);
            }
        }

        // Jika ada upload file large image
        if ($request->hasFile('large_image')) {
            // Simpan path file large image lama
            $oldFile = $news->large_image;
            
            // simpan large image baru
            $validated['large_image'] = $request->file('large_image')->store('news/large_images', 'public');

            // simpan jns_file baru
            $extension = strtolower($request->file('large_image')->getClientOriginalExtension());
            $validated['jns_file'] = match ($extension) {
                'jpg', 'jpeg', 'png' => 'image',
                'pdf' => 'pdf',
                default => null,
            };  

            // hapus large image lama dari storage
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        // otomatis update show since & off from jika publish berubah
        if ($news->publish === 'T' && $validated['publish'] === 'Y') {
            $validated['show_since'] = now()->toDateString();
            $validated['off_from'] = null;
        } elseif ($news->publish === 'Y' && $validated['publish'] === 'T') {
            $validated['off_from'] = now()->toDateString();
            $validated['show_since'] = null; // tetap menggunakan show_since lama
        }

        // otomatis update date_news jika publish berubah
        // if ($news->publish === 'T' && $validated['publish'] === 'Y') {
        //     $validated['date_news'] = now()->toDateString();
        // } elseif ($news->publish === 'Y' && $validated['publish'] === 'T') {
        //     $validated['date_news'] = $news->entry_date->toDateString();
        // }

        // Update data berita
        $news->update($validated);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Simpan path file lama sebelum dihapus
        $thumbnailPath = $news->thumbnail_image;
        $largeImagePath = $news->large_image;

        try {
            DB::transaction(function () use ($news) {
                $news->delete();
            });

            // Hapus thumbnail dari storage
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            // Hapus large image dari storage
            if ($largeImagePath && Storage::disk('public')->exists($largeImagePath)) {
                Storage::disk('public')->delete($largeImagePath);
            }

            return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
            
        } catch (\Throwable $e) {
            // error message ke log server
            Log::error('Gagal menghapus berita ID ' . $news->id . ": " . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus berita. Silahkan coba lagi.');
        }
    }
}
