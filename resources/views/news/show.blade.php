@extends('layouts.app') 

@section('title', 'News')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">
        @include('components.page-header', [ 'title' => 'View News',
        'breadcrumbs' => [ [ 'title' => 'Dashboard', 'route' => 'dashboard' ], [
        'title' => 'News', 'route' => 'news.index' ] ] ])

        <!-- ROW-1 OPEN-->
        <div class="row">
            <div class="col-lg-12">
                <div class="py-4">
                    <div class="text-center">
                        {{-- Judul berita --}}
                        <h4 class="display-6 fw-semibold">
                            {{ $news->heading }}
                        </h4>
                        <div class="d-flex justify-content-between align-items-center px-4 text-start">
                            {{-- Kategori --}}
                            <p>
                                {{ $news->flag_kegiatan == 'T' ? 'Berita' : 'Kegiatan' }}
                            </p>
                            {{-- Tanggal publish --}}
                            <p class="">
                                {{ $news->show_since ? $news->show_since->format('d-m-Y') : 'Belum dipublish' }}
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Large Image --}}
                @if ($news->jns_file === 'image')
                <div class="text-center mb-4">
                    {{-- Jika berupa gambar --}}
                    <img
                        src="{{ asset('storage/' . $news->large_image) }}"
                        alt="large image"
                        class="img-fluid"
                    />
                </div>
                @elseif ($news->jns_file === 'pdf')
                <div class="mb-4">
                    {{-- Jika berupa pdf --}}
                    <div class="show-pdf ratio ratio-16x9 mb-2">
                        <embed 
                            src="{{ asset('storage/' . $news->large_image) }}" 
                            type="application/pdf" 
                            class="rounded border" 
                        />
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- ROW-1 CLOSED -->

        <!-- ROW-2 OPEN -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row">
                            {{-- Isi berita --}}
                            <div class="col-12 my-auto overflow-scroll">
                                {!! $news->content !!}
                            </div>

                            {{-- Sumber berita --}}
                            <div class="col-12 mt-5 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fst-italic text-muted">
                                    <p class="mb-0">Sumber: {{ $news->source }}</p>
                                </div>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <a href="{{ route('news.index') }}" class="btn btn-light me-2">Kembali</a>
                                    <a href="{{ route('news.edit', $news->slug) }}" class="btn btn-primary">Edit Berita</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 CLOSED -->
    </div>
</div>
<!-- End::app-content -->

@endsection
