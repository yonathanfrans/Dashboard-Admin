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
        @include('components.page-header', [ 'title' => 'Update News',
        'breadcrumbs' => [ [ 'title' => 'Dashboard', 'route' => 'dashboard' ], [
        'title' => 'News', 'route' => 'news.index' ] ] ])

        <!-- ROW-1 -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Flash message success & error --}}
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-start mb-3" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fe fe-check-circle fs-18 me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        @endif @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show text-start mb-3" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fe fe-alert-octagon fs-18 me-2"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        @endif
                        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="newsForm" class="row g-3 mt-0">
                            @csrf
                            @method('PATCH')

                            <div class="col-md-9">
                                {{-- Judul Berita --}}
                                <label for="heading" class="form-label">Judul Berita</label>
                                <input
                                    type="text"
                                    class="form-control @error('heading') is-invalid @enderror"
                                    name="heading"
                                    id="heading"
                                    placeholder="Masukkan judul berita.."
                                    value="{{ old('heading', $news->heading) }}"
                                    aria-label="Heading"
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
                                    <option value="T" {{ old('flag_kegiatan', $news->flag_kegiatan) == 'T' ? 'selected' : '' }}>Berita</option>
                                    <option value="Y" {{ old('flag_kegiatan', $news->flag_kegiatan) == 'Y' ? 'selected' : '' }}>Kegiatan</option>
                                </select>
                                @error('flag_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
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
                                />
                                <p class="fs-12 p-2 fw-light">Biarkan kosong jika tidak diubah. Allowed (PNG, JPG, JPEG) & Max 2MB</p>
                                @error('thumbnail_image')
                                <div class="text-danger fs-12 ms-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                {{-- Preview Thumbnail --}}
                                @if ($news->thumbnail_image)
                                <div class="mt-2">
                                    <small class="text-muted d-block">Gambar Sampul saat ini:</small>
                                    <div class="show-thumbnail">
                                        <img src="{{ asset('storage/' . $news->thumbnail_image) }}" alt="Thumbnail" class="img-thumbnail" />
                                    </div>
                                </div>
                                @endif
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
                                />
                                <p class="fs-12 p-2 fw-light">Biarkan kosong jika tidak diubah. Allowed (PNG, JPG, JPEG, PDF) & Max 5MB</p>
                                @error('large_image')
                                <div class="text-danger fs-12 ms-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                {{-- Preview Large Image --}}
                                @if ($news->jns_file === 'image')
                                <div class="mt-2">
                                    <small class="text-muted d-block">Gambar Utama saat ini:</small>
                                    <div class="show-thumbnail">
                                        <img src="{{ asset('storage/' . $news->large_image) }}" alt="Large Image" class="img-thumbnail" />
                                    </div>
                                </div>
                                @elseif ($news->jns_file === 'pdf')
                                <div class="mt-2">
                                    <small class="text-muted d-block">Dokumen saat ini:</small>
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

                            {{-- Isi berita --}}
                            <div class="col-12">
                                <label for="editor" class="form-label">Isi Berita</label>
                                <div id="editor">{!! old('content', $news->content) !!}</div>
                                <textarea name="content" id="content" hidden></textarea>
                                @error('content')
                                <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sumber berita --}}
                            <div class="col-md-6">
                                <label for="source" class="form-label">Sumber</label>
                                <input
                                    type="text"
                                    name="source"
                                    class="form-control @error('source') is-invalid @enderror"
                                    id="source"
                                    placeholder="Masukkan sumber berita..."
                                    value="{{ old('source', $news->source) }}"
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
                                    <option value="T" {{ old('publish', $news->publish) == 'T' ? 'selected' : '' }}>Unpublished</option>
                                    <option value="Y" {{ old('publish', $news->publish) == 'Y' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('publish')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal dibuat --}}
                            <div class="col-md-4">
                                <label for="date_news" class="form-label">Tanggal Dibuat</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="date_news"
                                    value="{{ $news->date_news?->format('d-m-Y') }}"
                                    readonly
                                />
                            </div>

                            {{-- Tanggal publish --}}
                            <div class="col-md-4">
                                <label for="show_since" class="form-label">Tanggal Publish</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="show_since"
                                    value="{{ $news->show_since?->format('d-m-Y')  }}"
                                    readonly
                                />
                            </div>

                            <div class="col-12 text-center mt-5">
                                <a href="{{ route('news.index') }}" class="btn btn-light me-2">Batal</a>
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
    {{-- Start Modal Delete --}}
    <div class="modal fade" id="deleteFileModal" tabindex="-1" aria-labelledby="deleteFileModalLabel" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteFileModalLabel">Hapus File</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-center">
                    <i class="fe fe-alert-circle fs-1 text-danger d-block mb-3"></i>
                    <p class="mb-0">Apakah anda yakin ingin menghapus file ini?</p>
                    <strong id="delete-file-name"></strong>
                </div>
                
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Delete --}}
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


<script src="{{ asset('assets/js/modalCRUD.js') }}"></script>

@endpush