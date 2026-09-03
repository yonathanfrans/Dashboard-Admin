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
                            {{ $news->title }}
                        </h4>
                        <div class="d-flex justify-content-between align-items-center px-4 text-start">
                            {{-- Kategori --}}
                            <p>
                                {{ $news->newsCategory->title }}
                            </p>
                            {{-- Tanggal publish --}}
                            <p class="">
                                {{ $news->tgl_publish ? $news->tgl_publish->format('d-m-Y') : 'Belum dipublish' }}
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Thumbnail --}}
                <div class="text-center mb-4">
                    <img
                        src="{{ asset('storage/' . $news->thumbnail) }}"
                        alt="thumbnail"
                        class="img-fluid"
                    />
                </div>
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
                            {{-- File pendukung --}}
                            @if ($news->files->isNotEmpty())
                            <div class="col-12 mt-5">
                                    <small class="text-muted d-block mb-2">File Pendukung:</small>
                                    @foreach ($news->files as $file)
                                    <div class="mb-1">
                                        <a href="{{ asset('storage/' . $file->file) }}" target="_blank" class="text-primary fs-13">
                                            Lihat File {{ $loop->iteration }}
                                        </a>
                                    </div>
                                    @endforeach
                            </div>
                            @endif
                            {{-- Sumber berita --}}
                            <div class="col-12 mt-5 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fst-italic text-muted">
                                    <p class="mb-0">Sumber: {{ $news->sumber }}</p>
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
