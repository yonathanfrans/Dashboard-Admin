@extends('layouts.app')

@section('title', 'News')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [
            'title' => 'News',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'route' => 'dashboard'
                ]
            ]
        ])

        <!-- ROW-1 -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card">
                    <div class="card-body product-table">
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
                        <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
                            <!-- Button Add News -->
                            <a href="{{ route('news.create') }}" class="btn btn-primary">
                                Tambah Berita +
                            </a>
                            {{-- Fitur filter --}}
                            <form action="{{ route('news.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                {{-- Filter status --}}
                                <select name="status" class="form-select" aria-label="Select status" onchange="this.form.submit()">
                                    <option selected disabled>Pilih status</option>
                                    <option value="">Semua status</option>
                                    <option value="Published" {{ request('status') == 'Published' ? 'selected' : '' }}>Published</option>
                                    <option value="Unpublished" {{ request('status') == 'Unpublished' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                                {{-- Filter kategori --}}
                                <select name="category_id" class="form-select" aria-label="Select category" onchange="this.form.submit()">
                                    <option selected disabled>Pilih kategori</option>
                                    <option value="">Semua kategori</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                    @endforeach
                                </select>
                                {{-- Filter search --}}
                                <input type="search" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                            </form>
                        </div>
                        

                        <div class="tab-content">
                            <div class="tab-pane border-0 p-0 active" id="tab5">
                                {{-- Table data --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap text-start">
                                        <thead class="border-top">
                                            <tr>
                                                <th class="text-center" scope="col">No</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Sumber</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($news as $item)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $news->firstItem() + $loop->index }}</th>
                                                <td>{{ Str::limit($item->title, 50) }}</td>
                                                <td>{{ $item->newsCategory->title ?? 'Belum ada kategori' }}</td>
                                                <td>{{ $item->sumber }}</td>
                                                <td>
                                                    @if ($item->status == 'Published')
                                                        <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Published</span>
                                                    @else
                                                        <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Unpublished</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a href="{{ route('news.show', $item->slug) }}" class="btn text-dark btn-sm" data-bs-toggle="tooltip" data-bs-original-title="View">
                                                            <span class="fe fe-eye fs-14"></span>
                                                        </a>

                                                        <a href="{{ route('news.edit', $item->slug) }}" class="btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="fe fe-edit fs-14"></span>
                                                        </a>

                                                        <button class="btn text-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteNewsModal" data-bs-original-title="Delete" data-id="{{ $item->id }}" data-title="{{ $item->title }}">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    Belum ada berita.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-6 my-auto">
                                <span>Showing {{ $news->firstItem() ?? 0 }} to {{ $news->lastItem() ?? 0 }} of {{ $news->total() }} entries</span>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex justify-content-end">
                                    {{ $news->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Start Modal Delete --}}
    <div class="modal fade" id="deleteNewsModal" tabindex="-1" aria-labelledby="deleteNewsModalLabel" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteNewsModalLabel">Hapus Berita</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-center">
                    <i class="fe fe-alert-circle fs-1 text-danger d-block mb-3"></i>
                    <p class="mb-0">Apakah anda yakin ingin menghapus berita ini?</p>
                    <strong id="delete-news-title"></strong>
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

@push("scripts")

<script src="{{ asset('assets/js/modalCRUD.js') }}"></script>
    
@endpush

