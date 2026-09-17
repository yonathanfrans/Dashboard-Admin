@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [
            'title' => 'FAQ',
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
                            <!-- Button Add FAQ -->
                            <a href="{{ route('faq.create') }}" class="btn btn-primary">
                                Tambah FAQ +
                            </a>
                            {{-- Fitur filter --}}
                            @use('App\Helpers\HashId')
                            <form action="{{ route('faq.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                {{-- Filter Menu --}}
                                <select name="id_sub" class="form-select" aria-label="Select menu" onchange="this.form.submit()">
                                    <option selected disabled>Pilih menu</option>
                                    <option value="">Semua menu</option>
                                    @foreach ($menus as $menu)
                                    @php
                                        $hashedId = HashId::encode($menu->id_sub);
                                        $isSelected = request('id_sub') === $hashedId;
                                    @endphp
                                    <option value="{{ $hashedId }}" {{ $isSelected ? 'selected' : '' }}>
                                        {{ $menu->menu }} - {{ $menu->sub_menu }}
                                    </option>
                                    @endforeach
                                </select>
                                {{-- Filter Jenis --}}
                                <select name="jenis" class="form-select" aria-label="Select type" onchange="this.form.submit()">
                                    <option selected disabled>Pilih jenis</option>
                                    <option value="">Semua jenis</option>
                                    <option value="Menu" {{ request('jenis') == 'Menu' ? 'selected' : '' }}>Menu (Teks)</option>
                                    <option value="pdf" {{ request('jenis') == 'pdf' ? 'selected' : '' }}>PDF Document</option>
                                </select>
                                {{-- Filter Status --}}
                                <select name="publish" class="form-select" aria-label="Select status" onchange="this.form.submit()">
                                    <option selected disabled>Pilih status</option>
                                    <option value="">Semua status</option>
                                    <option value="Y" {{ request('publish') == 'Y' ? 'selected' : '' }}>Published</option>
                                    <option value="T" {{ request('publish') == 'T' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                                {{-- Filter search --}}
                                <input type="search" name="search" class="form-control" placeholder="Cari pertanyaan..." value="{{ request('search') }}">
                            </form>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane border-0 p-0 active" id="tab5">
                                {{-- Table data --}}
                                <div class="table-responsive overflow-x-scroll">
                                    <table class="table table-bordered text-nowrap text-start">
                                        <thead class="border-top">
                                            <tr>
                                                <th class="text-center" scope="col">No</th>
                                                <th scope="col">Pertanyaan</th>
                                                <th scope="col">Menu</th>
                                                <th scope="col">Jenis</th>
                                                <th scope="col">Jawaban</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($faqs as $faq)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $faqs->firstItem() + $loop->index }}</th>
                                                <td>{{ Str::limit($faq->pertanyaan, 50) }}</td>
                                                <td>
                                                    <strong>{{ $faq->faqMenu->menu ?? '-' }}</strong>
                                                    <small class="text-muted">{{ $faq->faqMenu->sub_menu ?? '-' }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $faq->jenis == 'pdf' ? 'bg-danger' : 'bg-info' }}">
                                                        {{ strtoupper($faq->jenis) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($faq->jenis == 'pdf' && $faq->link)
                                                    <a href="{{ asset('storage/' . $faq->link) }}" target="_blank" class="small text-primary">
                                                        <i class="bi bi-file-earmark-pdf"></i> Lihat File PDF
                                                    </a>
                                                    @else
                                                    {{ Str::limit(strip_tags($faq->jawaban), 30) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($faq->publish == 'Y')
                                                        <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Published</span>
                                                    @else
                                                        <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Unpublished</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a href="{{ route('faq.edit', $faq) }}" class="btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="fe fe-edit fs-14"></span>
                                                        </a>

                                                        <button 
                                                            class="btn text-danger btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteFaqModal" 
                                                            data-bs-original-title="Delete" 
                                                            data-id="{{ $faq->getRouteKey() }}" 
                                                            data-pertanyaan="{{ $faq->pertanyaan }}">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    Belum ada FAQ.
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
                            @if ($faqs->total() < 11) 
                            <div class="col-sm-12 col-md-6 my-auto">
                                <span>Showing {{ $faqs->firstItem() ?? 0 }} to {{ $faqs->lastItem() ?? 0 }} of {{ $faqs->total() }} entries</span>
                            </div>
                            @else
                            <div class="col-sm-12">
                                <div class="d-flex flex-row justify-content-end">
                                    {{ $faqs->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    {{-- Start Modal Delete --}}
    <div 
        class="modal fade" 
        id="deleteFaqModal" 
        tabindex="-1" 
        aria-labelledby="deleteFaqModalLabel" 
        data-bs-keyboard="false" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" class="modal-content" id="deleteFaqForm">
                @csrf
                @method('DELETE')
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteFaqModalLabel">Hapus FAQ</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-center">
                    <i class="fe fe-alert-circle fs-1 text-danger d-block mb-3"></i>
                    <p class="mb-0">Apakah anda yakin ingin menghapus FAQ ini?</p>
                    <strong id="delete-faq"></strong>
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
    
@endpush