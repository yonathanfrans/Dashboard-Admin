<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsCategoryRequest;
use App\Http\Requests\UpdateNewsCategoryRequest;
use App\Models\NewsCategory;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Urutkan berdasarkan kategori yang baru dibuat dan pagination 10 data per halaman
        $categories = NewsCategory::latest('created_at')->paginate(10);

        return view('news.category', compact('categories'));
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
    public function store(StoreNewsCategoryRequest $request)
    {
        // Validasi request form 
        $validated = $request->validated();

        // generate slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $count = 1;

        // Jika request slug == db slug
        while (NewsCategory::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }
        $validated['slug'] = $slug;

        // Buat kategori baru
        NewsCategory::create($validated);

        return redirect()->back()->with('success', 'Kategori berita berhasil ditambahkan!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsCategoryRequest $request, NewsCategory $newsCategory)
    {
        // Validasi request form 
        $validated = $request->validated();

        // Update slug jika title berubah
        if ($validated['title'] !== $newsCategory->title) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $count = 1;

            // Cek slug ke db, abaikan id berita agar tidak bentrok
            while (NewsCategory::where('slug', $slug)->where('id', '!=', $newsCategory->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        // Update kategori berita
        $newsCategory->update($validated);

        $newsTitle = $newsCategory->title;

        return redirect()->back()->with('success', 'Kategori ' . $newsTitle . ' berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsCategory $newsCategory)
    {
        // Tolak penghapusan jika kategori masih memiliki berita
        $newsTitle = $newsCategory->title;

        if ($newsCategory->news()->exists()) {
            return redirect()->back()->with('error', 'Kategori ' . $newsTitle . ' tidak dapat dihapus karena masih digunakan oleh berita');
        }

        // Hapus kategori berita
        $newsCategory->delete();

        return redirect()->back()->with('success', 'Kategori ' . $newsTitle . ' berhasil dihapus!');
    }
}
