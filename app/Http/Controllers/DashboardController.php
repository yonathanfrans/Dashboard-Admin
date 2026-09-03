<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;

class DashboardController extends Controller
{
    public function index() {
        $jumlahKategori = NewsCategory::count();
        $jumlahBerita = News::count();
        $jumlahBeritaPublish = News::where('status', 'Published')->count();
        $jumlahBeritaUnpublish = News::where('status', 'Unpublished')->count();
        $latestNews = News::with('newsCategory')->where('status', 'Published')->latest('tgl_publish')->take(4)->get();

        return view('dashboard', compact('jumlahKategori', 'jumlahBerita', 'jumlahBeritaPublish', 'jumlahBeritaUnpublish', 'latestNews'));
    }

}
