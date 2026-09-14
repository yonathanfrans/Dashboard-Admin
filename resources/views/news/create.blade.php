@extends('layouts.app') 

@section('title', 'News') 
@push('styles')

<link rel="stylesheet" href="{{ asset('assets/libs/quill/quill.snow.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/quill/quill.bubble.css') }}">
    
@endpush

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [ 'title' => 'Create News',
        'breadcrumbs' => [ [ 'title' => 'Dashboard', 'route' => 'dashboard' ], [
        'title' => 'News', 'route' => 'news.index' ] ] ])

        <!-- ROW-1 -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm" class="row g-3 mt-0">
                            @csrf

                            {{-- Judul Berita --}}
                            <div class="col-md-9">
                                <label for="heading" class="form-label">Judul Berita</label>
                                <input
                                    type="text"
                                    class="form-control @error('heading') is-invalid @enderror"
                                    name="heading"
                                    id="heading"
                                    placeholder="Masukkan judul berita.."
                                    aria-label="Heading"
                                    value="{{ old('heading') }}"
                                    required
                                />
                                @error('heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Berita --}}
                            <div class="col-md-3">
                                <label for="flag_kegiatan" class="form-label">Jenis Berita</label>
                                <select name="flag_kegiatan" class="form-select @error('flag_kegiatan') is-invalid @enderror" aria-label="Select type" required>
                                    <option selected disabled>Pilih jenis</option>
                                    <option value="T" {{ old('flag_kegiatan') == 'T' ? 'selected' : '' }}>Berita</option>
                                    <option value="Y" {{ old('flag_kegiatan') == 'Y' ? 'selected' : '' }}>Kegiatan</option>
                                </select>
                                @error('flag_kegiatan')
                                <div class="invalid-feedback">Please select a news type.</div>
                                @enderror
                            </div>

                            {{-- Thumbnail Image --}}
                            <div class="col-md-6">
                                <label for="thumbnail_image" class="form-label">Gambar Sampul (Thumbnail List)</label>
                                <input
                                    type="file"
                                    class="form-control @error('thumbnail_image') is-invalid @enderror"
                                    name="thumbnail_image"
                                    id="thumbnail_image"
                                    accept=".png,.jpg,.jpeg"
                                    required
                                />
                                <p class="fs-12 p-2 fw-light">Allowed (PNG, JPG, JPEG) & Max 2MB</p>
                                @error('thumbnail_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Large Image --}}
                            <div class="col-md-6">
                                <label for="large_image" class="form-label">Dokumen / Gambar Utama (Isi Berita)</label>
                                <input
                                    type="file"
                                    class="form-control @error('large_image') is-invalid @enderror"
                                    name="large_image"
                                    id="large_image"
                                    accept=".png,.jpg,.jpeg,.pdf"
                                    required
                                />
                                <p class="fs-12 p-2 fw-light">Allowed (PNG, JPG, JPEG, PDF) & Max 5MB</p>
                                @error('large_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Isi berita --}}
                            <div class="col-12">
                                <label for="editor" class="form-label">Isi Berita</label>
                                <div id="editor">{!! old('content') !!}</div>
                                <textarea name="content" id="content" hidden></textarea>
                                @error('content')
                                <div class="text-danger fs-12 mt-1">Please enter the news content.</div>
                                @enderror
                            </div>

                            {{-- Sumber berita --}}
                            <div class="col-md-4">
                                <label for="source" class="form-label">Sumber</label>
                                <input
                                    type="text"
                                    name="source"
                                    class="form-control @error('source') is-invalid @enderror"
                                    id="source"
                                    placeholder="Masukkan sumber berita..."
                                    value="{{ old('source') }}"
                                    required
                                />
                                @error('source')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status berita --}}
                            <div class="col-md-4">
                                <label for="publish" class="form-label">Status</label>
                                <select name="publish" id="publish" class="form-select @error('publish') is-invalid @enderror" aria-label="Select status" required>
                                    <option value="T" {{ old('publish') == 'T' ? 'selected' : '' }}>Unpublished</option>
                                    <option value="Y" {{ old('publish') == 'Y' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('publish')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center flex-wrap gap-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                <a href="{{ route('news.index') }}" class="btn btn-light me-2">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End::app-content -->

@endsection

@push('scripts')

<!-- Quill Editor JS -->
<script src="{{ asset('assets/libs/quill/quill.min.js') }}"></script>

{{-- Modul Resize Image Quill --}}
<script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>

<!-- Internal Quill JS -->
<script src="{{ asset('assets/js/quill-editor.js') }}"></script>

@endpush