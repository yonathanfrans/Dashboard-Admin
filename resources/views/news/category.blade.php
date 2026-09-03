@extends('layouts.app') @section('title', 'Category') @section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [ 'title' => 'Category',
        'breadcrumbs' => [ [ 'title' => 'Dashboard', 'route' => 'dashboard' ] ]
        ])

        <!-- ROW-1 -->
        <div class="row">
            <div class="col-12 col-sm-12 text-end">
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
                        <!-- Button Add Category -->
                        <div class="mb-3 text-start">
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                Tambah Kategori +
                            </button>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane border-0 p-0 active" id="tab5">
                                {{-- Table data --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap mb-0 text-start">
                                        <thead class="border-top">
                                            <tr>
                                                <th class="text-center" scope="col">No</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Slug</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($categories as $category)
                                            <tr>
                                                <th class="text-center" scope="row">
                                                    {{ $categories->firstItem() + $loop->index }}
                                                </th>
                                                <td>{{ $category->title }}</td>
                                                <td>{{ $category->slug }}</td>
                                                <td>
                                                    <div class="g-2">
                                                        <button class="btn text-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-slug="{{ $category->slug }}" data-title="{{ $category->title }}">
                                                            <span class="fe fe-edit fs-14"></span>
                                                        </button>

                                                        <button class="btn text-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal" data-bs-original-title="Delete" data-id="{{ $category->id }}" data-title="{{ $category->title }}">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    Belum ada kategori berita.
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
                            <div class="col-sm-12 col-md-6 my-auto text-start">
                                <span>Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} entries</span>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex justify-content-end">
                                    {{ $categories->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Start Modal Create --}}
    <div
        class="modal fade"
        id="createCategoryModal"
        tabindex="-1"
        aria-labelledby="createCategoryModalLabel"
        data-bs-keyboard="false"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <form
                action="{{ route('category.store') }}"
                method="POST"
                class="modal-content"
            >
                @csrf {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="createCategoryModalLabel">
                        Tambah Kategori
                    </h6>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label
                            for="create-category-title"
                            class="form-label fs-14 text-dark"
                            >Masukkan Judul Kategori</label
                        >
                        <input
                            type="text"
                            class="form-control @error('title') is-invalid @enderror"
                            id="create-category-title"
                            name="title"
                            placeholder="Judul kategori..."
                            value="{{ old('title') }}"
                            required
                        />

                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Create --}} 
    {{-- Start Modal Edit --}}
    <div
        class="modal fade"
        id="editCategoryModal"
        tabindex="-1"
        aria-labelledby="editCategoryModalLabel"
        data-bs-keyboard="false"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" class="modal-content">
                @csrf 
                @method('PATCH') 
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="editCategoryModalLabel">
                        Update Kategori
                    </h6>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label
                            for="edit-category-title"
                            class="form-label fs-14 text-dark"
                            >Judul Kategori</label
                        >
                        <input
                            type="text"
                            class="form-control @error('title') is-invalid @enderror"
                            id="edit-category-title"
                            name="title"
                            placeholder="Judul kategori..."
                            value="{{ old('title') }}"
                            required
                        />
                    </div>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Edit --}} 
    {{-- Start Modal Delete --}}
    <div
        class="modal fade"
        id="deleteCategoryModal"
        tabindex="-1"
        aria-labelledby="deleteCategoryModalLabel"
        data-bs-keyboard="false"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" class="modal-content">
                @csrf 
                @method('DELETE') 
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteCategoryModalLabel">
                        Hapus Kategori
                    </h6>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-center">
                    <i
                        class="fe fe-alert-circle fs-1 text-danger d-block mb-3"
                    ></i>
                    <p class="mb-0">
                        Apakah anda yakin ingin menghapus kategori ini?
                    </p>
                    <strong id="delete-category-title"></strong>
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

@endsection @push("scripts")

<script src="{{ asset('assets/js/modalCRUD.js') }}"></script>

@endpush
