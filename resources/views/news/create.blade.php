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
                                <label for="title" class="form-label">Judul Berita</label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    name="title"
                                    id="title"
                                    placeholder="Masukkan judul berita.."
                                    aria-label="Title"
                                    value="{{ old('title') }}"
                                    required
                                />
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori Berita --}}
                            <div class="col-md-3">
                                <label for="news_category_id" class="form-label">Kategori Berita</label>
                                <select name="news_category_id" class="form-select @error('news_category_id') is-invalid @enderror" aria-label="Select category" required>
                                    <option selected disabled>Pilih kategori</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('news_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('news_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Thumbnail --}}
                            <div class="col-md-6">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <input
                                    type="file"
                                    class="form-control @error('thumbnail') is-invalid @enderror"
                                    name="thumbnail"
                                    id="thumbnail"
                                    accept=".png,.jpg,.jpeg"
                                    required
                                />
                                <p class="fs-12 p-2 fw-light">Allowed (PNG, JPG, JPEG) & Max 2MB</p>
                                @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Isi berita --}}
                            <div class="col-12">
                                <label for="editor" class="form-label">Isi Berita</label>
                                <div id="editor">{!! old('content') !!}</div>
                                <textarea name="content" id="content" hidden></textarea>
                                @error('content')
                                <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- File Pendukung --}}
                            <div class="col-md-4">
                                <label for="files" class="form-label">File Pendukung</label>
                                <input
                                    type="file"
                                    name="files[]"
                                    class="form-control @error('files.*') is-invalid @enderror"
                                    id="files"
                                    accept=".pdf,.png,.jpg,.jpeg"
                                    multiple
                                />
                                <p class="fs-12 p-2 fw-light">Allowed (PDF, PNG, JPG, JPEG) & Max 5MB per file</p>
                                @error('files.*')
                                <div class="text-danger fs-12 ms-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sumber berita --}}
                            <div class="col-md-4">
                                <label for="sumber" class="form-label">Sumber</label>
                                <input
                                    type="text"
                                    name="sumber"
                                    class="form-control @error('sumber') is-invalid @enderror"
                                    id="sumber"
                                    placeholder="Masukkan sumber berita..."
                                    value="{{ old('sumber') }}"
                                    required
                                />
                                @error('sumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status berita --}}
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" aria-label="Select status" required>
                                    <option value="Unpublished" {{ old('status') == 'Unpublished' ? 'selected' : '' }}>Unpublished</option>
                                    <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
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