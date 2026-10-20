@extends('layouts.app')

@section('title', 'Tracking Dokumen Permohonan')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content mt-4">
    <div class="container-fluid">
        @include('components.page-header', [
            'title' => 'Tracking Dokumen Permohonan',
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
                        {{-- Fitur filter --}}
                        <form action="{{ route('trackingSiup.index') }}" method="GET" class="mb-3 d-flex justify-content-between align-items-center flex-wrap px-3">
                            {{-- Filter search --}}
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"> <i class="ri-search-line"></i> </div>
                                    <input 
                                        type="search" 
                                        name="search" 
                                        class="form-control" 
                                        placeholder="Cari No. Permohonan, No. Izin,  Pemilik..." 
                                        value="{{ request('search') }}"
                                    >
                                </div>
                            </div>
                        </form>

                        <div class="tab-content">
                            <div class="tab-pane border-0 p-0 active" id="tab5">
                                {{-- Table data --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap text-start">
                                        <thead class="border-top">
                                            <tr>
                                                <th scope="col">No. Permohonan</th>
                                                <th scope="col">No. Agenda</th>
                                                <th scope="col">Nama Pemilik</th>
                                                <th scope="col">Jenis Permohonan</th>
                                                <th scope="col">No. Izin</th>
                                                <th scope="col">Tanggal Kirim</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($trackingLists as $item)
                                            <tr 
                                                class="row-tracking" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewProgressSiupModal"
                                                data-bs-original-title="View"
                                                data-id="{{ $item->id_permohonan_izin }}"
                                                data-nomor-agenda="{{ $item->nomor_agenda }}"
                                                data-tgl-permohonan="{{ $item->tanggal_kirim_pendok->format('d-m-Y H:i:s') }}"
                                                data-nama-pemilik="{{ $item->nama_pemilik }}"
                                                data-keterangan="{{ $item->keterangan }}"
                                                data-nama-jenis-izin="{{ $item->nama_jenis_izin }}"
                                                data-nama-status-izin="{{ $item->nama_status_izin }}"
                                                data-nomor-izin="{{ $item->nomor_izin }}"
                                                data-progress1="{{ $item->progress1 }}"
                                                data-progress3="{{ $item->progress3 }}"
                                                data-progress4="{{ $item->progress4 }}"
                                                data-progress5="{{ $item->progress5 }}"
                                                data-progress7a="{{ $item->progress7a }}"
                                                data-progress7b="{{ $item->progress7b }}"
                                                data-catatan-stop-proses="{{ $item->catatan_stop_proses }}"
                                                data-status-terbit="{{ $item->status_terbit }}"
                                                data-status-batal="{{ $item->status_batal }}"
                                            >
                                                <td>{{ $item->id_permohonan_izin }}</td>
                                                <td>{{ $item->nomor_agenda }}</td>
                                                <td>
                                                    {{ $item->nama_pemilik }} 
                                                    <br />
                                                    <span class="text-muted small"> 
                                                        {{ $item->keterangan ? $item->keterangan : '' }}
                                                    </span>
                                                </td>
                                                <td>{{ $item->nama_jenis_izin }} {{ $item->nama_status_izin }}</td>
                                                <td>{{ $item->nomor_izin ?? '-' }}</td>
                                                <td>{{ $item->tanggal_kirim_pendok->format('d-m-Y H:i:s') }}</td>
                                                <td>
                                                    @if($item->status_batal)
                                                        <span class="badge bg-danger-transparent rounded-pill text-danger fs-sm px-3 py-2">BATAL</span>
                                                    @elseif($item->status_terbit === 'TERBIT')
                                                        <span class="badge bg-success-transparent rounded-pill text-success fs-sm px-3 py-2">Terbit</span>
                                                    @else
                                                        <span class="badge bg-secondary-transparent rounded-pill text-secondary fs-sm px-3 py-2">Proses</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    @if ($hasSearch)
                                                        <span class="text-muted">Data permohonan tidak ditemukan. Silakan coba kata kunci lain.</span>
                                                    @else
                                                        <span class="text-muted"><i class="ri-search-line me-1"></i> Silakan masukkan nomor permohonan, nomor agenda, atau nama pemilik pada kolom pencarian di atas untuk menampilkan data.</span>
                                                    @endif
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
                            @if (!$trackingLists->hasPages()) 
                            <div class="col-sm-12 col-md-6 my-auto">
                                <span>Showing {{ $trackingLists->firstItem() ?? 0 }} to {{ $trackingLists->lastItem() ?? 0 }} of {{ $trackingLists->total() }} entries</span>
                            </div>
                            @else
                            <div class="col-sm-12">
                                <div class="d-flex flex-row justify-content-end">
                                    {{ $trackingLists->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    {{-- Start Modal View --}}
    <div 
        class="modal fade" 
        id="viewProgressSiupModal" 
        tabindex="-1" 
        aria-labelledby="viewProgressSiupModalLabel" 
        data-bs-keyboard="false" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="viewProgressSiupModalLabel">Detail Progress</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-start">
                    <!-- Informasi Ringkas -->
                    <div class="row row-gap-3 mb-3 p-3 bg-light rounded border">
                        <div class="col-md-4">
                            <small class="text-muted d-block">No. Permohonan / Agenda</small>
                            <span class="fw-bold text-primary" id="view-progress-id">-</span> / 
                            <span class="fw-bold" id="view-progress-nomor-agenda">-</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Nama Pemilik</small>
                            <span class="fw-bold" id="view-progress-nama-pemilik">-</span> 
                            <br>
                            <span class="text-muted small" id="view-progress-keterangan"></span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Tanggal Permohonan</small>
                            <span class="fw-bold" id="view-progress-tgl-permohonan">-</span> 
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Jenis Permohonan</small>
                            <span id="view-progress-jenis-status">-</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Nomor Izin</small>
                            <span class="fw-medium" id="view-progress-nomor-izin">-</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Status Permohonan</small>
                            <span id="view-progress-status-terbit" class="badge bg-warning">PROSES</span>
                        </div>
                    </div>

                    <!-- Timeline Progress -->
                    <h6 class="fw-bold mb-2 mt-4 text-primary">Timeline Progress</h6>
                    <div class="py-2 px-2">
                        <ul class="timeline-progress mb-0">
                            <!-- Progress 1 -->
                            <li class="timeline-item mb-5 d-none" id="item-progress1">
                                <h5 class="fw-bold fs-15 mb-1">Tahap 1</h5>
                                <p class="text-muted small mb-0" id="desc-progress1">-</p>
                            </li>

                            <!-- Progress 3 -->
                            <li class="timeline-item mb-5 d-none" id="item-progress3">
                                <h5 class="fw-bold fs-15 mb-1">Tahap 3</h5>
                                <p class="text-muted small mb-0" id="desc-progress3">-</p>
                            </li>

                            <!-- Progress 4 -->
                            <li class="timeline-item mb-5 d-none" id="item-progress4">
                                <h5 class="fw-bold fs-15 mb-1">Tahap 4</h5>
                                <p class="text-muted small mb-0" id="desc-progress4">-</p>
                            </li>

                            <!-- Progress 5 -->
                            <li class="timeline-item mb-5 d-none" id="item-progress5">
                                <h5 class="fw-bold fs-15 mb-1">Tahap 5</h5>
                                <p class="text-muted small mb-0" id="desc-progress5">-</p>
                            </li>

                            <!-- Progress 7a -->
                            <li class="timeline-item mb-5 d-none" id="item-progress7a">
                                <h5 class="fw-bold fs-15 mb-1">Tahap 7a</h5>
                                <p class="text-muted small mb-0" id="desc-progress7a">-</p>
                            </li>

                            <!-- Progress 7b -->
                            <li class="timeline-item mb-5 d-none" id="item-progress7b">
                                <h5 class="fw-bold fs-15 mb-1">Tahap 7b</h5>
                                <p class="text-muted small mb-0" id="desc-progress7b">-</p>
                            </li>

                            <!-- Pesan Kosong Jika Tidak Ada Progress Sama Sekali -->
                            <li id="empty-timeline" class="text-muted text-center py-3 d-none">
                                Belum ada data tahapan progress yang terekam.
                            </li>
                        </ul>
                    </div>

                    <div class="mt-3 d-none" id="wrapper-catatan">
                        <small class="text-danger fw-bold">Catatan Stop Proses:</small>
                        <p class="text-danger mb-0 small" id="view-progress-catatan-stop-proses">-</p>
                    </div>
                </div>
                
                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal View --}}
</div>
<!-- End::app-content -->

@endsection

@push("scripts")

<script src="{{ asset('assets/js/modalCRUD.js') }}"></script>
    
@endpush