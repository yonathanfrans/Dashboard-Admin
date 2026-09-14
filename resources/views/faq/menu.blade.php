@extends('layouts.app')

@section('title', 'Kategori FAQ')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [
            'title' => 'Kategori FAQ',
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
                            <!-- Button Add Category -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryFaqModal"> 
                                Tambah Kategori +
                            </button>
                            {{-- Fitur filter --}}
                            <form action="{{ route('faqMenu.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                {{-- Filter Kategori --}}
                                <select name="menu" class="form-select" aria-label="Select kegiatan" onchange="this.form.submit()">
                                    <option selected disabled>Pilih menu</option>
                                    <option value="">Semua menu</option>
                                    @foreach ($existingMenus as $menuOption)
                                    <option value="{{ $menuOption }}" {{ request('menu') == $menuOption ? 'selected' : '' }}>
                                        {{ $menuOption }}
                                    </option>
                                    @endforeach
                                </select>
                                {{-- Filter search --}}
                                <input type="search" name="search" class="form-control" placeholder="Cari menu..." value="{{ request('search') }}">
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
                                                <th scope="col">Menu</th>
                                                <th scope="col">Sub Menu</th>
                                                <th scope="col">No Urut</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($faqMenus as $faqMenu)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $faqMenus->firstItem() + $loop->index }}</th>
                                                <td>{{ Str::limit($faqMenu->menu, 50) }}</td>
                                                <td>{{ Str::limit($faqMenu->sub_menu, 50)}}</td>
                                                <td>{{ $faqMenu->no_urut }}</td>
                                                <td>
                                                    @if ($faqMenu->aktif == 'Y')
                                                        <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Active</span>
                                                    @else
                                                        <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <button 
                                                            class="btn text-primary btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editCategoryFaqModal" 
                                                            data-bs-original-title="Edit" 
                                                            data-id="{{ $faqMenu->getRouteKey() }}" 
                                                            data-menu="{{ $faqMenu->menu }}"
                                                            data-sub-menu="{{ $faqMenu->sub_menu }}"
                                                            data-aktif="{{ $faqMenu->aktif }}">
                                                            <span class="fe fe-edit fs-14"></span>
                                                        </button>

                                                        <button 
                                                            class="btn text-danger btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteCategoryFaqModal" 
                                                            data-bs-original-title="Delete" 
                                                            data-id="{{ $faqMenu->getRouteKey() }}" 
                                                            data-sub-menu="{{ $faqMenu->sub_menu }}">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    Belum ada kategori FAQ.
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
                            @if ($faqMenus->total() < 11) 
                            <div class="col-sm-12 col-md-6 my-auto">
                                <span>Showing {{ $faqMenus->firstItem() ?? 0 }} to {{ $faqMenus->lastItem() ?? 0 }} of {{ $faqMenus->total() }} entries</span>
                            </div>
                            @else
                            <div class="col-sm-12">
                                <div class="d-flex flex-row justify-content-end">
                                    {{ $faqMenus->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Start Modal Create --}}
    <div
        class="modal fade"
        id="createCategoryFaqModal"
        tabindex="-1"
        aria-labelledby="createCategoryFaqModalLabel"
        data-bs-keyboard="false"
        aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered">
            <form
                action="{{ route('faqMenu.store') }}"
                method="POST"
                class="modal-content"
                id="createCategoryFaqForm">
                @csrf 
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="createCategoryFaqModalLabel">
                        Tambah Kategori
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">
                    <div class="my-3 d-flex flex-column row-gap-3">
                        <div class="mb-3">
                            <label for="create-category-faq-menu-select" class="form-label fs-14 text-dark">Masukkan Judul Menu</label>
                            <select id="create-category-faq-menu-select" class="form-select @error('menu') is-invalid @enderror" required>
                                @if ($existingMenus->isNotEmpty())
                                <option value="" disabled selected>Pilih Menu</option>
                                @foreach ($existingMenus as $menuOption)
                                    <option value="{{ $menuOption }}">{{ $menuOption }}</option>
                                @endforeach
                                <option value="__NEW__">+ Tambah Menu Baru</option>
                                @else
                                <option value="__NEW__">+ Tambah Menu Baru</option>
                                @endif
                            </select>
                            <input 
                                type="text"
                                id="create-category-faq-menu-input"
                                class="form-control my-2 {{ $existingMenus->isNotEmpty() ? 'd-none' : '' }}"
                                placeholder="Masukkan menu baru"
                                {{ $existingMenus->isEmpty() ? 'required' : '' }}>

                            <input type="hidden" name="menu" id="create-category-faq-menu-hidden">
                            @error('menu')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="create-category-faq-sub-menu" class="form-label fs-14 text-dark">Masukkan Sub Menu</label>
                            <input
                                type="text"
                                class="form-control @error('sub_menu') is-invalid @enderror"
                                id="create-category-faq-sub-menu"
                                name="sub_menu"
                                placeholder="Judul Sub Menu"
                                value="{{ old('sub_menu') }}"
                                required
                            />
                            @error('sub_menu')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="create-category-faq-status" class="form-label fs-14 text-dark">Pilih Status</label>
                            <select name="aktif" id="aktif" class="form-select @error('aktif') is-invalid @enderror" aria-label="Select status" required>
                                <option value="T" {{ old('aktif') == 'T' ? 'selected' : '' }}>Inactive</option>
                                <option value="Y" {{ old('aktif') == 'Y' ? 'selected' : '' }}>Active</option>
                            </select>
                        </div>

                        @error('aktif')
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

    {{-- Start Modal Update --}}
    <div
        class="modal fade"
        id="editCategoryFaqModal"
        tabindex="-1"
        aria-labelledby="editCategoryModalFaqLabel"
        data-bs-keyboard="false"
        aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered">
            <form
                method="POST"
                class="modal-content"
                id="editCategoryFaqForm">
                @csrf 
                @method('PATCH')
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="updateCategoryModalFaqLabel">
                        Update Kategori
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">
                    <div class="my-3 d-flex flex-column row-gap-3">
                        <div class="mb-3">
                            <label for="update-category-faq-menu" class="form-label fs-14 text-dark">Masukkan Judul Menu</label>
                            <select name="menu" id="update-category-faq-menu" class="form-select" required>
                                <option value="" disabled>Pilih Menu</option>
                                @foreach ($existingMenus as $menuOption)
                                <option value="{{ $menuOption }}">{{ $menuOption }}</option>
                                @endforeach
                            </select>
                            @error('menu')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="update-category-faq-sub-menu" class="form-label fs-14 text-dark">Masukkan Sub Menu</label>
                            <input
                                type="text"
                                class="form-control @error('sub_menu') is-invalid @enderror"
                                id="update-category-faq-sub-menu"
                                name="sub_menu"
                                placeholder="Judul Sub Menu..."
                                required
                            />
                            @error('sub_menu')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="update-category-faq-status" class="form-label fs-14 text-dark">Pilih Status</label>
                            <select name="aktif" id="update-category-faq-status" class="form-select @error('aktif') is-invalid @enderror" aria-label="Select status" required>
                                <option value="T" {{ old('aktif') == 'T' ? 'selected' : '' }}>Inactive</option>
                                <option value="Y" {{ old('aktif') == 'Y' ? 'selected' : '' }}>Active</option>
                            </select>
                        </div>

                        @error('status')
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
    {{-- End Modal Update --}}
    
    {{-- Start Modal Delete --}}
    <div 
        class="modal fade" 
        id="deleteCategoryFaqModal" 
        tabindex="-1" 
        aria-labelledby="deleteCategoryFaqModalLabel" 
        data-bs-keyboard="false" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" class="modal-content" id="deleteCategoryFaqForm">
                @csrf
                @method('DELETE')
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteCategoryFaqModalLabel">Hapus Kategori FAQ</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-center">
                    <i class="fe fe-alert-circle fs-1 text-danger d-block mb-3"></i>
                    <p class="mb-0">Apakah anda yakin ingin menghapus kategori FAQ ini?</p>
                    <strong id="delete-category-faq-sub-menu"></strong>
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

<script src="{{ asset('assets/js/modalCRUD.js') }}"></script>
<script src="{{ asset('assets/js/formFAQ.js') }}"></script>
    
@endpush