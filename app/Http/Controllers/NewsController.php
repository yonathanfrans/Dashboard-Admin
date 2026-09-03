<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsFile;
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
        // Ambil data kategori
        $categories = NewsCategory::all();

        $news = News::with('newsCategory') // Eager Loading untuk mencegah N+1 query
            ->when($request->search, function ($query, $search) {
                // Filter pencarian judul atau konten
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'ilike', "%{$search}%")
                        ->orWhere('content', 'ilike', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                // Filter kategori
                $query->where('news_category_id', $categoryId);
            })
            ->when($request->status, function ($query, $status) {
                // Filter status
                $query->where('status', $status);
            })
            ->latest('created_at') // Urutkan berdasarkan berita yang baru dibuat
            ->paginate(10)          // Pagination 10 data per halaman
            ->withQueryString();     // Menyimpan parameter URL saat pindah halaman pagination

        return view('news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = NewsCategory::all();

        return view('news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        // Validasi request form
        $validated = $request->validated();

        // generate slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $count = 1;

        // Jika request slug == db slug
        while (News::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }
        $validated['slug'] = $slug;

        // Store thumbnail ke folder
        $validated['thumbnail'] = $request->file('thumbnail')->store('news/thumbnails', 'public');

        // Hapus files dari validated agar tidak ikut News::create()
        $files = $validated['files'] ?? [];
        unset($validated['files']);

        // otomatis tgl publish
        if ($validated['status'] === 'Published') {
            $validated['tgl_publish'] = $validated['tgl_publish'] ?? now();
        } else {
            $validated['tgl_publish'] =null;
        }

        // Simpan ke db
        $news = News::create($validated);

        // Simpan multiple file
        foreach ($files as $file) {
            $path = $file->store('news/files', 'public');

            $news->files()->create(['file' => $path]);
        }

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->load('newsCategory', 'files');

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $news->load('files');

        $categories = NewsCategory::all();

        return view('news.update', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        // Validasi request form 
        $validated = $request->validated();

        // Update slug jika title berubah
        if ($validated['title'] !== $news->title) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $count = 1;

            // Cek slug ke db, abaikan id berita agar tidak bentrok
            while (News::where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        // Jika ada upload file thumbnail
        if ($request->hasFile('thumbnail')) {
            // Simpan path file thumbnail lama
            $oldThumbnail = $news->thumbnail;

            // simpan thumbnail baru
            $validated['thumbnail'] = $request->file('thumbnail')->store('news/thumbnails', 'public');

            // hapus thumbnail lama dari storage 
            if ($oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
                Storage::disk('public')->delete($oldThumbnail);
            }
        }

        // otomatis tgl publish
        if ($news->status === 'Unpublished' && $validated['status'] === 'Published') {
            $validated['tgl_publish'] = now()->toDateString();
        } elseif ($validated['status'] === 'Unpublished') {
            $validated['tgl_publish'] =null;
        }

        // ambil files
        $files = $validated['files'] ?? [];
        unset($validated['files']);

        // Update data berita
        $news->update($validated);

        // tambahkan file baru
        foreach ($files as $file) {
            $path = $file->store('news/files', 'public');

            $news->files()->create(['file' => $path]);
        }

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Simpan path file lama sebelum dihapus
        $thumbnailPath = $news->thumbnail;
        $filePaths = $news->files()->pluck('file')->toArray();

        try {
            DB::transaction(function () use ($news) {
                $news->delete();
            });

            // Hapus thumbnail dari storage
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            // Hapus semua file
            foreach ($filePaths as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
            
        } catch (\Throwable $e) {
            // error message ke log server
            Log::error('Gagal menghapus berita ID ' . $news->id . ": " . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus berita. Silahkan coba lagi.');
        }
    }

    public function destroyFile(NewsFile $newsFile) 
    {
        try {
            // Simpan path sebelum data dihapus
            $filePath = $newsFile->file;

            // Hapus record dari database
            $newsFile->delete();

            // Hapus file dari storage
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()->with('success', 'File berhasil dihapus.');
        } catch (\Throwable $e) {
            // error message ke log server
            Log::error('Gagal menghapus file berita ID' . $newsFile->id . ': ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus file.');
        }
    }
}
