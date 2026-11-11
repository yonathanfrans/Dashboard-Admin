@extends('layouts.app')

@section('title', 'Sub Alat Tangkap')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content mt-7">
    <div class="container-fluid">
        @include('components.page-header', [
            'title' => 'Sub Alat Tangkap',
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
                        <form action="{{ route('subAlatTangkap.index') }}" method="GET" class="mb-3 d-flex justify-content-between align-items-center flex-wrap px-3">
                            <div class="d-flex align-items-center gap-2">
                                {{-- Filter kelompok alat tangkap --}}
                                <select name="kelompok_alat_tangkap" class="form-select" aria-label="Select kelompok alat tangkap" onchange="this.form.submit()">
                                    <option selected disabled>Pilih Kel. Alat Tangkap</option>
                                    <option value="">Semua Kelompok</option>
                                    <option value="KAPAL TANGKAP" {{ request('kelompok_alat_tangkap') == 'KAPAL TANGKAP' ? 'selected' : '' }}>KAPAL TANGKAP</option>
                                    <option value="KAPAL ANGKUT PORT TO PORT" {{ request('kelompok_alat_tangkap') == 'KAPAL ANGKUT PORT TO PORT' ? 'selected' : '' }}>KAPAL ANGKUT PORT TO PORT</option>
                                    <option value="KAPAL ANGKUT BUDIDAYA" {{ request('kelompok_alat_tangkap') == 'KAPAL ANGKUT BUDIDAYA' ? 'selected' : '' }}>KAPAL ANGKUT BUDIDAYA</option>
                                    <option value="KAPAL PEMBANTU OPERASIONAL" {{ request('kelompok_alat_tangkap') == 'KAPAL PEMBANTU OPERASIONAL' ? 'selected' : '' }}>KAPAL PEMBANTU OPERASIONAL</option>
                                    <option value="KAPAL ANGKUT DPI TO PORT" {{ request('kelompok_alat_tangkap') == 'KAPAL ANGKUT DPI TO PORT' ? 'selected' : '' }}>KAPAL ANGKUT DPI TO PORT</option>
                                </select>
                                {{-- Filter aktif --}}
                                <select name="aktif" class="form-select" aria-label="Select active" onchange="this.form.submit()">
                                    <option selected disabled>Pilih Status</option>
                                    <option value="">Semua Status</option>
                                    <option value="YA" {{ request('aktif') == 'YA' ? 'selected' : '' }}>Aktif</option>
                                    <option value="TIDAK" {{ request('aktif') == 'TIDAK' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            {{-- Filter search --}}
                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"> <i class="ri-search-line"></i> </div>
                                    <input 
                                        type="search" 
                                        name="search" 
                                        class="form-control" 
                                        placeholder="Cari alat tangkap..." 
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
                                                <th class="text-center" scope="col">No</th>
                                                <th scope="col">Nama Alat Tangkap</th>
                                                <th scope="col">Kelompok API Izin</th>
                                                <th scope="col">Keterangan Group</th>
                                                <th scope="col">Alat Tangkap PNBP</th>
                                                <th scope="col">Kelompok Alat Tangkap</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($subAlatTangkapList as $item)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $subAlatTangkapList->firstItem() + $loop->index }}</th>
                                                <td class="text-wrap">{{ $item->keterangan }}</td>
                                                <td>{{ $item->kelompok_api_izin ? $item->kelompok_api_izin : '-' }}</td>
                                                <td class="text-wrap">{{ $item->keterangan_group ? $item->keterangan_group : '-' }}</td>
                                                <td class="text-wrap">{{ $item->alat_tangkap_pnbp ? $item->alat_tangkap_pnbp : '-' }}</td>
                                                <td class="text-wrap">{{ $item->kelompok_alat_tangkap ? $item->kelompok_alat_tangkap : '-' }}</td>
                                                <td>
                                                    <span 
                                                        class="btn btn-info-light btn-wave btn-sm"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewSubAlatTangkapModal"
                                                        data-bs-original-title="View"
                                                        data-kode="{{ $item->kode_alat_tangkap ?? '-' }}"
                                                        data-keterangan="{{ $item->keterangan }}"
                                                        data-nama-epit="{{ $item->nama_alat_tangkap_epit ?? '-' }}"
                                                        data-kelompok-api-izin="{{ $item->kelompok_api_izin ?? '-' }}"
                                                        data-nm-en="{{ $item->nm_alat_tangkap_en ?? '-' }}"
                                                        data-pnbp="{{ $item->alat_tangkap_pnbp ?? '-' }}"
                                                        data-kelompok-akt="{{ $item->kelompok_alat_tangkap ?? '-' }}"
                                                        data-koefisien="{{ $item->koefisien_produktivitas ?? '-' }}"
                                                        data-palkah="{{ $item->konversi_palkah ?? '-' }}"
                                                        data-kuota="{{ $item->kuota_kapal ? number_format($item->kuota_kapal, 0, ',', '.') : '-' }}"
                                                        data-harga="{{ $item->harga_ikan_kg ? 'Rp ' . number_format($item->harga_ikan_kg, 0, ',', '.') : '-' }}"
                                                        data-status-pengangkut="{{ $item->status_pengangkut ?? 'TIDAK' }}"
                                                        data-status-rumpon="{{ $item->status_rumpon ?? 'TIDAK' }}"
                                                        data-status-armada="{{ $item->status_armada ?? '-' }}"
                                                        data-aktif="{{ $item->aktif ?? 'YA' }}"
                                                        data-kbli="{{ $item->kode_kbli ?? '-' }}"
                                                        data-grup-silat="{{ $item->grup_api_silat ?? '-' }}"
                                                        data-keterangan-group="{{ $item->keterangan_group ?? '-' }}"
                                                        data-jumlah-hari-melaut="{{ $item->jumlah_hari_melaut ?? '-' }}"
                                                        data-pasca-produksi="{{ $item->flag_pasca_produksi ?? '-' }}"
                                                        data-alat-tangkap-sama="{{ $item->alat_tangkap_sama ?? '-' }}"
                                                        data-alat-tangkap-alias="{{ $item->alat_tangkap_alias ?? '-' }}"
                                                        data-display="{{ $item->display ?? '-' }}"
                                                        data-status-satu-kesatuan-usaha="{{ $item->status_satu_kesatuan_usaha ?? '-' }}"
                                                        data-group-api="{{ $item->group_api ?? '-' }}"
                                                        data-kelompok-api="{{ $item->kelompok_api ?? '-' }}"
                                                        data-validasi-ukuran-kapal="{{ $item->validasi_ukuran_kapal ?? '-'}}"
                                                        data-list-jenis-izin="{{ $item->list_jenis_izin ?? '-' }}"
                                                        data-periode-izin="{{ $item->periode_izin ?? '-' }}"
                                                        data-id-sub-alat-tangkap="{{ $item->id_sub_alat_tangkap ?? '-' }}"
                                                        data-id-sub-alat-tangkap-lama="{{ $item->id_sub_alat_tangkap_lama ?? '-' }}"
                                                        data-id-sub-alat-tangkap-baru="{{ $item->id_sub_alat_tangkap_baru ?? '-' }}"
                                                        data-id-alat-tangkap="{{ $item->id_alat_tangkap ?? '-' }}"
                                                        data-id-fishing-gear="{{ $item->fishing_gear_id ?? '-' }}"
                                                        data-id-alat-tangkap-pusdatin="{{ $item->id_alat_tangkap_pusdatin ?? '-' }}"
                                                        data-id-jenis-izin="{{ $item->id_jenis_izin ?? '-' }}"
                                                        data-id-sub-alat-tangkap-migrasi="{{ $item->id_sub_alat_tangkap_migrasi ?? '-' }}"
                                                        data-id-pengguna-buat="{{ $item->id_pengguna_buat ?? '-' }}"
                                                        data-tanggal-buat="{{ $item->tanggal_buat ?? '-' }}"
                                                        data-id-pengguna-ubah="{{ $item->id_pengguna_ubah ?? '-' }}"
                                                        data-tanggal-ubah="{{ $item->tanggal_ubah ?? '-' }}"
                                                        data-id-pengguna-hapus="{{ $item->id_pengguna_hapus ?? '-' }}"
                                                        data-tanggal-hapus="{{ $item->tanggal_hapus ?? '-' }}"
                                                        data-id2000="{{ $item->id2000 ?? '-' }}"
                                                    >
                                                        Lihat Detail
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    Belum ada data sub alat tangkap yang tersedia.
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
                            @if (!$subAlatTangkapList->hasPages()) 
                            <div class="col-sm-12 col-md-6 my-auto">
                                <span>Showing {{ $subAlatTangkapList->firstItem() ?? 0 }} to {{ $subAlatTangkapList->lastItem() ?? 0 }} of {{ $subAlatTangkapList->total() }} entries</span>
                            </div>
                            @else
                            <div class="col-sm-12">
                                <div class="d-flex flex-row justify-content-end">
                                    {{ $subAlatTangkapList->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Start Modal View --}}
    <div 
        class="modal fade" 
        id="viewSubAlatTangkapModal" 
        tabindex="-1" 
        aria-labelledby="viewSubAlatTangkapModalLabel" 
        data-bs-keyboard="false" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="viewSubAlatTangkapModalLabel">Detail Sub Alat Tangkap</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body text-start">
                    <!-- 1. Informasi Utama -->
                    <div class="mb-3 p-3 bg-light rounded border">
                        <small class="text-muted d-block">Nama Alat Tangkap</small>
                        <span class="fw-bold fs-15 text-primary" id="detail-keterangan">-</span>
                    </div>

                    <!-- 2. Informasi Data ID -->
                    <h6 class="fw-bold mb-2 text-primary">Informasi Data ID</h6>
                    <div class="row g-3 mb-3 p-3 border rounded">
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Sub Alat Tangkap</small>
                            <span class="fw-semibold" id="detail-id-sub-alat-tangkap">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Sub Alat Tangkap Lama</small>
                            <span class="fw-semibold" id="detail-id-sub-alat-tangkap-lama">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Sub Alat Tangkap Baru</small>
                            <span class="fw-semibold" id="detail-id-sub-alat-tangkap-baru">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Alat Tangkap</small>
                            <span class="fw-semibold" id="detail-id-alat-tangkap">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Fishing Gear</small>
                            <span class="fw-semibold" id="detail-id-fishing-gear">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Jenis Izin</small>
                            <span class="fw-semibold" id="detail-id-jenis-izin">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Alat Tangkap Pusdatin</small>
                            <span class="fw-semibold" id="detail-id-alat-tangkap-pusdatin">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Sub Alat Tangkap Migrasi</small>
                            <span class="fw-semibold" id="detail-id-sub-alat-tangkap-migrasi">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Pengguna Buat</small>
                            <span class="fw-semibold" id="detail-id-pengguna-buat">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tanggal Buat</small>
                            <span class="fw-semibold" id="detail-tanggal-buat">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Pengguna Ubah</small>
                            <span class="fw-semibold" id="detail-id-pengguna-ubah">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tanggal Ubah</small>
                            <span class="fw-semibold" id="detail-tanggal-ubah">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID Pengguna Hapus</small>
                            <span class="fw-semibold" id="detail-id-pengguna-hapus">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tanggal Hapus</small>
                            <span class="fw-semibold" id="detail-tanggal-hapus">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">ID 2000</small>
                            <span class="fw-semibold" id="detail-id-2000">-</span>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white h-100">
                                <small class="text-muted d-block">Kode Alat Tangkap</small>
                                <span class="fw-semibold" id="detail-kode">-</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white h-100">
                                <small class="text-muted d-block">Status Keaktifan</small>
                                <span class="badge bg-success" id="detail-aktif">YA</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white h-100">
                                <small class="text-muted d-block">Status Armada</small>
                                <span class="fw-semibold" id="detail-status-armada">-</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white h-100">
                                <small class="text-muted d-block">Kode KBLI</small>
                                <span class="fw-semibold" id="detail-kode-kbli">-</span>
                            </div>
                        </div>
                    </div>


                    <!-- 3. Klasifikasi & Kategori -->
                    <h6 class="fw-bold mb-2 text-primary">Klasifikasi & Kategori</h6>
                    <div class="row g-3 mb-3 p-3 border rounded">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Nama e-PIT</small>
                            <span class="fw-medium" id="detail-nama-epit">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Nama English (RFMO)</small>
                            <span class="fw-medium" id="detail-nm-en">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Alat Tangkap PNBP</small>
                            <span class="fw-medium" id="detail-pnbp">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Alat Tangkap Sama</small>
                            <span class="fw-medium" id="detail-alat-tangkap-sama">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Alat Tangkap Alias</small>
                            <span class="fw-medium" id="detail-alat-tangkap-alias">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Kelompok Alat Tangkap</small>
                            <span class="fw-medium" id="detail-kelompok-akt">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Kelompok API / Izin</small>
                            <span class="fw-medium text-break" id="detail-kelompok-api-izin">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Group API / SILAT</small>
                            <span class="fw-medium" id="detail-grup-api-silat">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Keterangan Group</small>
                            <span class="fw-medium" id="detail-keterangan-group">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">List Jenis Izin</small>
                            <span class="fw-medium" id="detail-list-jenis-izin">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Periode Izin</small>
                            <span class="fw-bold text-info" id="detail-periode-izin">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Display</small>
                            <span class="fw-medium" id="detail-display">-</span>
                        </div>
                    </div>

                    <!-- 4. Parameter Teknis -->
                    <h6 class="fw-bold mb-2 text-primary">Parameter Teknis</h6>
                    <div class="row g-3 mb-3 p-3 border rounded bg-light">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Koefisien Produktivitas</small>
                            <span class="fw-bold text-dark" id="detail-koefisien">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Konversi Palkah</small>
                            <span class="fw-bold text-dark" id="detail-palkah">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Kuota Kapal</small>
                            <span class="fw-bold text-dark" id="detail-kuota">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Validasi Ukuran Kapal</small>
                            <span class="fw-bold text-dark text-break" id="detail-validasi-ukuran-kapal">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Harga Ikan / Kg</small>
                            <span class="fw-bold text-success" id="detail-harga">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Jumlah Hari Melaut</small>
                            <span class="fw-bold text-info" id="detail-jumlah-hari-melaut">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Pasca Produksi</small>
                            <span class="badge bg-secondary" id="detail-pasca-produksi">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Status Pengangkut</small>
                            <span class="badge bg-secondary" id="detail-status-pengangkut">TIDAK</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Status Rumpon</small>
                            <span class="badge bg-secondary" id="detail-status-rumpon">TIDAK</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Status Satu Kesatuan Usaha</small>
                            <span class="badge bg-secondary" id="detail-status-satu-kesatuan-usaha">TIDAK</span>
                        </div>
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

@push('scripts')

<script src="{{ asset('assets/js/modalCRUD.js') }}"></script>

@endpush