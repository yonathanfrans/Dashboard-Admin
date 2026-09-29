@extends('layouts.app')

@section('title', 'Permohonan Hak Akses')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [
            'title' => 'Permohonan Hak Akses',
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
                            <a href="{{ route('accessRequest.create') }}" class="btn btn-primary">
                                Tambah Permohonan +
                            </a>
                            {{-- Fitur filter --}}
                            @use('App\Helpers\HashId')
                            <form action="{{ route('accessRequest.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                {{-- Filter Jenis Permintaan --}}
                                <select name="jns_permintaan" class="form-select" aria-label="Select type" onchange="this.form.submit()">
                                    <option selected disabled>Pilih permintaan</option>
                                    <option value="">Semua permintaan</option>
                                    <option value="pendaftaran" {{ request('jns_permintaan') == 'pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                                    <option value="penutupan" {{ request('jns_permintaan') == 'penutupan' ? 'selected' : '' }}>Penutupan</option>
                                </select>
                                {{-- Filter Status --}}
                                <select name="status" class="form-select" aria-label="Select status" onchange="this.form.submit()">
                                    <option selected disabled>Pilih status</option>
                                    <option value="">Semua status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                {{-- Filter Aktif --}}
                                <select name="aktif" class="form-select" aria-label="Select active" onchange="this.form.submit()">
                                    <option selected disabled>Pilih aktif</option>
                                    <option value="">Semua aktif</option>
                                    <option value="Y" {{ request('aktif') == 'Y' ? 'selected' : '' }}>Active</option>
                                    <option value="T" {{ request('aktif') == 'T' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                {{-- Filter search --}}
                                <input type="search" name="search" class="form-control" placeholder="Cari nama, email, unit kerja..." value="{{ request('search') }}">
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
                                                <th scope="col">Nama</th>
                                                <th scope="col">Unit Kerja</th>
                                                <th scope="col">Permintaan</th>
                                                <th scope="col">Akses</th>
                                                <th scope="col">Masa Berlaku</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aktif</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($accessRequests as $item)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $accessRequests->firstItem() + $loop->index }}</th>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->unit_kerja }}</td>
                                                <td>{{ $item->jns_permintaan }}</td>
                                                <td>
                                                    @if (is_array($item->jns_akses))
                                                        @foreach ($item->jns_akses as $akses)
                                                            <span class="badge bg-light text-dark border me-1">{{ ucfirst(str_replace('_', ' ', $akses)) }}</span>
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $item->masa_berlaku->format('d M Y') }}</td>
                                                <td>
                                                    @if ($item->status == 'pending')
                                                        <span class="badge bg-outline-warning p-2 px-3">Pending</span>
                                                    @elseif ($item->status == 'approved')
                                                        <span class="badge bg-outline-success p-2 px-3">Approved</span>
                                                    @else
                                                        <span class="badge bg-outline-danger p-2 px-3">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->aktif == 'Y')
                                                        <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Active</span>
                                                    @else
                                                        <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a href="{{ route('accessRequest.edit', $item) }}" class="btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="fe fe-edit fs-14"></span>
                                                        </a>

                                                        {{-- <button 
                                                            class="btn text-danger btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteAccessRequestModal" 
                                                            data-bs-original-title="Delete" 
                                                            data-id="{{ $item->getRouteKey() }}" 
                                                            data-nama="{{ $item->nama }}">
                                                            <span class="fe fe-trash-2 fs-14"></span>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">
                                                    Belum ada Permohonan.
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
                            @if ($accessRequests->total() < 11) 
                            <div class="col-sm-12 col-md-6 my-auto">
                                <span>Showing {{ $accessRequests->firstItem() ?? 0 }} to {{ $accessRequests->lastItem() ?? 0 }} of {{ $accessRequests->total() }} entries</span>
                            </div>
                            @else
                            <div class="col-sm-12">
                                <div class="d-flex flex-row justify-content-end">
                                    {{ $accessRequests->links('pagination::bootstrap-5') }}
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
        id="deleteAccessRequestModal" 
        tabindex="-1" 
        aria-labelledby="deleteAccessRequestModalLabel" 
        data-bs-keyboard="false" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" class="modal-content" id="deleteAccessRequestForm">
                @csrf
                @method('DELETE')
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteAccessRequestModalLabel">Hapus Permohonan Hak Akses</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-center">
                    <i class="fe fe-alert-circle fs-1 text-danger d-block mb-3"></i>
                    <p class="mb-0">Apakah anda yakin ingin menghapus permohonan ini?</p>
                    <strong id="delete-access-request"></strong>
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