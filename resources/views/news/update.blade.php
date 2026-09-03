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
                        <form action="{{ route('news.update', $news->slug) }}" method="POST" enctype="multipart/form-data" id="newsForm" class="row g-3 mt-0">
                            @csrf
                            @method('PATCH')

                            <div class="col-md-9">
                                {{-- Judul Berita --}}
                                <label for="title" class="form-label">Judul Berita</label>
                                <input
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    name="title"
                                    id="title"
                                    placeholder="Masukkan judul berita.."
                                    value="{{ old('title', $news->title) }}"
                                    aria-label="Title"
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
                                    <option disabled>Pilih kategori</option>
                                     @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('news_category_id', $news->news_category_id) == $category->id ? 'selected' : '' }}>
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
                                />
                                <p class="fs-12 p-2 fw-light">Biarkan kosong jika tidak diubah. Allowed (PNG, JPG, JPEG) & Max 2MB</p>
                                @error('thumbnail')
                                <div class="text-danger fs-12 ms-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                @if ($news->thumbnail)
                                <div class="mt-2">
                                    <small class="text-muted d-block">Thumbnail saat ini:</small>
                                    <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="Thumbnail" class="img-thumbnail">
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
                            {{-- File pendukung --}}
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
                                <p class="fs-12 p-2 fw-light">Biarkan kosong jika tidak diubah. Allowed (PDF, PNG, JPG, JPEG) & Max 5MB per file</p>
                                @if ($news->files->count())
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-2">File saat ini:</small>
                                    @foreach ($news->files as $file)
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        {{-- Lihat File --}}
                                        <a href="{{ asset('storage/' . $file->file) }}" target="_blank" class="text-primary fs-13">
                                            Lihat File {{ $loop->iteration }}
                                        </a>
                                        {{-- Hapus File --}}
                                        <button type="button" class="btn btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#deleteFileModal" data-id="{{ $file->id }}" data-file="File {{ $loop->iteration }}">
                                            <span class="fe fe-trash-2 fs-14x"></span>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
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
                                    value="{{ old('sumber', $news->sumber) }}"
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
                                    <option value="Unpublished" {{ old('status', $news->status) == 'Unpublished' ? 'selected' : '' }}>Unpublished</option>
                                    <option value="Published" {{ old('status', $news->status) == 'Published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Tanggal dibuat --}}
                            <div class="col-md-4">
                                <label for="tgl-dibuat" class="form-label">Tanggal Dibuat</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tgl-dibuat"
                                    value="{{ $news->created_at?->format('d-m-Y') }}"
                                    readonly
                                />
                            </div>
                            {{-- Tanggal publish --}}
                            <div class="col-md-4">
                                <label for="tgl-publish" class="form-label">Tanggal Publish</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tgl-publish"
                                    value="{{ $news->tgl_publish?->format('d-m-Y') }}"
                                    readonly
                                />
                            </div>
                            <div class="col-12 text-center">
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