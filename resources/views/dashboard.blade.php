@extends('layouts.app') 

@section('title', 'Dashboard') 

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title my-auto">Dashboard</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 -->
        <div class="row">
            <!-- Total Berita -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-around">
                            <i class="fe fe-inbox text-secondary fs-3"></i> 
                            <div class="text-center">
                                <h6 class="fw-normal">Total Semua Berita</h6>
                                <h2 class="mb-0 text-dark fw-semibold">
                                    {{ $jumlahSemuaBerita }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Berita Kegiatan -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-around">
                            <i class="fe fe-layers text-secondary fs-3"></i> 
                            <div class="text-center">
                                <h6 class="fw-normal">Total Berita Kegiatan</h6>
                                <h2 class="mb-0 text-dark fw-semibold">
                                    {{ $jumlahBeritaKegiatan }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Berita yang dipublish -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-around">
                            <i class="fe fe-upload-cloud text-secondary fs-3"></i> 
                            <div class="text-center">
                                <h6 class="fw-normal">Total Berita Publish</h6>
                                <h2 class="mb-0 text-dark fw-semibold">
                                    {{ $jumlahBeritaPublish }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Berita yang belum dipubllish -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-around">
                            <i class="fe fe-download-cloud text-secondary fs-3"></i> 
                            <div class="text-center">
                                <h6 class="fw-normal">Total Berita Unpublish</h6>
                                <h2 class="mb-0 text-dark fw-semibold">
                                    {{ $jumlahBeritaUnpublish }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 END -->

        {{-- ROW 2 --}}
        <h6 class="my-4 text-muted">Berita terbaru</h6>
        <div class="row">
            @forelse ($latestNews as $news)
            <!-- Card Berita terbaru -->
            <div class="col-xl-3">
                <div class="card custom-card">
                    <img src="{{ asset('storage/' . $news->thumbnail_image) }}" class="card-img-top thumbnail-card" alt="Thumbnail berita">
                    <div class="card-body d-flex flex-column">
                        {{-- Jenis & Tanggal --}}
                        <div class="d-flex justify-content-between align-items-center my-2">
                            <span class="badge bg-primary fs-8">{{ $news->flag_kegiatan == 'T' ? 'Berita' : 'Kegiatan' }}</span>
                            <small class="text-muted fs-11">
                                {{ $news->date_news ? \Carbon\Carbon::parse($news->date_news)->format('d M Y') : '-' }}
                            </small>
                        </div>
                        <h6 class="card-title fw-semibold mb-3 text-truncate">{{ $news->heading }}</h6>
                        <p class="card-text text-muted fs-13">{{ Str::limit(strip_tags($news->content), 100, '...') }}</p>
                        <a href="{{ route('news.show', $news) }}" class="btn btn-primary">Lihat berita</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    Belum ada berita terbaru yang dipublikasikan.
                </div>
            </div>
            @endforelse
        </div>
        {{-- ROW 2 END --}}

    </div>
</div>
<!-- End::app-content -->

@endsection