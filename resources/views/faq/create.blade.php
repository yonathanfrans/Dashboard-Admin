@extends('layouts.app')

@section('title', 'Create FAQ')
@push('styles')

<link rel="stylesheet" href="{{ asset('assets/libs/quill/quill.snow.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/quill/quill.bubble.css') }}">
    
@endpush

@section('content') 

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [ 'title' => 'Create FAQ',
        'breadcrumbs' => [ [ 'title' => 'Dashboard', 'route' => 'dashboard' ], [
        'title' => 'FAQ', 'route' => 'faq.index' ] ] ])

        <!-- ROW-1 -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data" id="faqForm" class="row g-3 mt-0">
                            @csrf

                            {{-- Sub Menu --}}
                            <div class="col-md-6">
                                <label for="id_sub" class="form-label">Kategori Sub Menu</label>
                                <select name="id_sub" class="form-select @error('id_sub') is-invalid @enderror" aria-label="Select menu" required>
                                    <option selected disabled>Pilih Sub Menu</option>
                                    @foreach ($menus as $menu)
                                    <option value="{{ $menu->id_sub }}" {{ old('id_sub') == $menu->id_sub ? 'selected' : '' }}>
                                        {{ $menu->menu }} - {{ $menu->sub_menu }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_sub')
                                <div class="invalid-feedback">Please select a sub menu.</div>
                                @enderror
                            </div>

                            {{-- Jenis FAQ --}}
                            <div class="col-md-6">
                                <label for="jenis" class="form-label">Jenis Konten FAQ</label>
                                <select name="jenis" id="faq-jenis-select" class="form-select @error('jenis') is-invalid @enderror" aria-label="Select type" required>
                                    <option selected disabled>Pilih jenis</option>
                                    <option value="Menu" {{ old('jenis') == 'Menu' ? 'selected' : '' }}>Menu (Teks)</option>
                                    <option value="pdf" {{ old('jenis') == 'pdf' ? 'selected' : '' }}>PDF Document</option>
                                </select>
                                @error('jenis')
                                <div class="invalid-feedback">Please select the type of FAQ content.</div>
                                @enderror
                            </div>

                            {{-- Pertanyaan --}}
                            <div class="col-md-9">
                                <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                <input
                                    type="text"
                                    class="form-control @error('pertanyaan') is-invalid @enderror"
                                    name="pertanyaan"
                                    id="pertanyaan"
                                    placeholder="Masukkan pertanyaan..."
                                    aria-label="Pertanyaan"
                                    value="{{ old('pertanyaan') }}"
                                    required
                                />
                                @error('pertanyaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jawaban (teks) --}}
                            <div class="col-12 d-none" id="field-jawaban">
                                <label for="editor" class="form-label">Jawaban</label>
                                <div id="editor">{!! old('jawaban') !!}</div>
                                <textarea name="jawaban" id="jawaban" hidden></textarea>
                                @error('jawaban')
                                <div class="text-danger fs-12 mt-1">Please fill in the FAQ answers.</div>
                                @enderror
                            </div>

                            {{-- Link file PDF --}}
                            <div class="col-md-4 d-none" id="field-link">
                                <label for="link" class="form-label">Upload file PDF</label>
                                <input
                                    type="file"
                                    class="form-control @error('link') is-invalid @enderror"
                                    name="link"
                                    id="link"
                                    accept=".pdf"
                                />
                                <p class="fs-12 p-2 fw-light">Allowed Only PDF & Max 5MB</p>
                                @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status FAQ --}}
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
                                <a href="{{ route('faq.index') }}" class="btn btn-light me-2">Kembali</a>
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

{{-- Script form FAQ --}}
<script src="{{ asset('assets/js/formFAQ.js') }}"></script>
    
@endpush