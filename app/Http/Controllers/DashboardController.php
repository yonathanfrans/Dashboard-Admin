<?php

namespace App\Http\Controllers;

use App\Models\News;

class DashboardController extends Controller
{
    public function index() {

        $jumlahSemuaBerita = News::count();
        $jumlahBeritaPublish = News::where('publish', 'Y')->count();
        $jumlahBeritaUnpublish = News::where('publish', 'T')->count();
        $jumlahBeritaKegiatan = News::where('flag_kegiatan', 'Y')->count();
        $latestNews = News::where('publish', 'Y')->latest('entry_date')->take(4)->get();

        return view('dashboard', compact('jumlahSemuaBerita', 'jumlahBeritaPublish', 'jumlahBeritaUnpublish', 'jumlahBeritaKegiatan', 'latestNews'));
    }

}
