@extends('layouts.app')

@section('title', 'Update Permohonan Hak Akses')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [ 'title' => 'Update Permohonan Hak Akses',
        'breadcrumbs' => [ [ 'title' => 'Dashboard', 'route' => 'dashboard' ], [
        'title' => 'Permohonan Hak Akses', 'route' => 'accessRequest.index' ] ] ])

        <!-- ROW-1 -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('accessRequest.update', $accessRequest) }}" method="POST" enctype="multipart/form-data" id="accessRequestForm" class="row g-4 mt-0" data-mode="edit">
                            @csrf
                            @method('PATCH')

                            {{-- Jenis Permintaan --}}
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="jns_permintaan" class="form-label">Jenis Permintaan</label>
                                        <input 
                                            type="text"
                                            class="form-control @error('jns_permintaan') is-invalid @enderror"
                                            name="jns_permintaan"
                                            id="jns_permintaan"
                                            aria-label="Jenis Permintaan"
                                            value="{{ old('jns_permintaan', $accessRequest->jns_permintaan) }}"
                                            readonly 
                                        />
                                        @error('jns_permintaan')
                                        <div class="invalid-feedback">Please select the field Jenis Permintaan.</div>
                                        @enderror
                                    </div>
                                    {{-- Nomor Formulir --}}
                                    <div class="col-md-4" id="nomor-formulir">
                                        <label for="nomor_formulir" class="form-label">Nomor Formulir</label>
                                        <input
                                            type="text"
                                            class="form-control @error('nomor_formulir') is-invalid @enderror"
                                            name="nomor_formulir"
                                            id="nomor_formulir"
                                            placeholder="Masukkan nomor formulir..."
                                            aria-label="Nomor Formulir"
                                            value="{{ old('nomor_formulir', $accessRequest->nomor_formulir) }}"
                                            readonly
                                        />
                                        @error('nomor_formulir')
                                        <div class="invalid-feedback">Please enter the field Nomor Formulir.</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Data Pemohon --}}
                            <div class="col-12" id="data-pemohon">
                                <hr class="mt-2 mb-4 text-muted">
                                <h6 class="fw-bold text-primary mb-4">Data Pemohon</h6>
                                <div class="row g-4">
                                    {{-- Nama --}}
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">Nama Pemohon</label>
                                        <input
                                            type="text"
                                            class="form-control @error('nama') is-invalid @enderror"
                                            name="nama"
                                            id="nama"
                                            placeholder="Masukkan nama pemohon..."
                                            aria-label="Nama"
                                            value="{{ old('nama', $accessRequest->nama) }}"
                                            required
                                        />
                                        @error('nama')
                                        <div class="invalid-feedback">Please enter the field nama</div>
                                        @enderror
                                    </div>
        
                                    {{-- Unit Kerja --}}
                                    <div class="col-md-4">
                                        <label for="unit_kerja" class="form-label">Unit Kerja Pemohon</label>
                                        <input
                                            type="text"
                                            class="form-control @error('unit_kerja') is-invalid @enderror"
                                            name="unit_kerja"
                                            id="input-Datalist"
                                            placeholder="Pilih unit kerja pemohon..."
                                            aria-label="Unit Kerja"
                                            value="{{ old('unit_kerja', $accessRequest->unit_kerja) }}"
                                            list="datalistOptions"
                                            required
                                        />
                                        <datalist id="datalistOptions">
                                            <option value="Dit. Usaha Penangkapan Ikan - DJPT">
                                            </option>
                                        </datalist>
                                        @error('unit_kerja')
                                        <div class="invalid-feedback">Please enter the field Unit Kerja</div>
                                        @enderror
                                    </div>
        
                                    {{-- Email --}}
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Email Pemohon</label>
                                        <input
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email"
                                            id="email"
                                            placeholder="Masukkan email pemohon..."
                                            aria-label="Email"
                                            value="{{ old('email', $accessRequest->email) }}"
                                            required
                                        />
                                        @error('email')
                                        <div class="invalid-feedback">Please enter the field Email</div>
                                        @enderror
                                    </div>
        
                                    {{-- Telepon --}}
                                    <div class="col-md-2">
                                        <label for="telepon" class="form-label">Telepon Pemohon</label>
                                        <input
                                            type="tel"
                                            class="form-control @error('telepon') is-invalid @enderror"
                                            name="telepon"
                                            id="telepon"
                                            placeholder="08123456789"
                                            pattern="[0-9]{10,13}"
                                            aria-label="Telepon"
                                            value="{{ old('telepon', $accessRequest->telepon) }}"
                                            required
                                        />
                                        @error('telepon')
                                        <div class="invalid-feedback">Please enter the field Telepon</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Hak Akses --}}
                            <div class="col-12" id="hak-akses">
                                <hr class="mt-2 mb-4 text-muted">
                                <h6 class="fw-bold text-primary mb-4">Hak Akses</h6>
                                <div class="row g-5">
                                    {{-- Jenis Akses --}}
                                    <div class="col-md-6">
                                        <label for="jns_akses" class="form-label">Jenis Akses</label>
                                        @php $oldAkses = old('jns_akses', $accessRequest->jns_akses ?? []); @endphp
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input jns-akses-check border-3" type="checkbox" name="jns_akses[]" value="database" id="akses_db" {{ in_array('database', $oldAkses) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="akses_db">Database</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input jns-akses-check border-3" type="checkbox" name="jns_akses[]" value="aplikasi" id="akses_app" {{ in_array('aplikasi', $oldAkses) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="akses_app">Aplikasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input jns-akses-check border-3" type="checkbox" name="jns_akses[]" value="sistem_operasi" id="akses_os" {{ in_array('sistem_operasi', $oldAkses) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="akses_os">Sistem Operasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input jns-akses-check border-3" type="checkbox" name="jns_akses[]" value="lainnya" id="akses_lainnya" {{ in_array('lainnya', $oldAkses) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="akses_lainnya">Lainnya</label>
                                            </div>
                                        </div>
                                        @error('jns_akses')
                                        <div class="invalid-feedback">Please check the field Jenis Akses</div>
                                        @enderror
                                    </div>
                                    {{-- Keterangan Aplikasi (Kondisional) --}}
                                    <div class="col-md-3" id="wrapper-keterangan-app">
                                        <label for="keterangan_aplikasi" class="form-label">Keterangan Aplikasi</label>
                                        <input
                                            type="text"
                                            class="form-control @error('keterangan_aplikasi') is-invalid @enderror"
                                            name="keterangan_aplikasi"
                                            id="keterangan_aplikasi"
                                            placeholder="Sebutkan nama aplikasi..."
                                            aria-label="Keterangan Aplikasi"
                                            value="{{ old('keterangan_aplikasi', $accessRequest->keterangan_aplikasi) }}"
                                        />
                                        @error('keterangan_aplikasi')
                                        <div class="invalid-feedback">Please enter the field Keterangan Aplikasi</div>
                                        @enderror
                                    </div>
                                    {{-- Keterangan Lainnya (Kondisional) --}}
                                    <div class="col-md-3" id="wrapper-keterangan-lainnya">
                                        <label for="keterangan_lainnya" class="form-label">Keterangan Akses Lainnya</label>
                                        <input
                                            type="text"
                                            class="form-control @error('keterangan_lainnya') is-invalid @enderror"
                                            name="keterangan_lainnya"
                                            id="keterangan_lainnya"
                                            placeholder="Sebutkan jenis akses lainnya..."
                                            aria-label="Keterangan Lainnya"
                                            value="{{ old('keterangan_lainnya', $accessRequest->keterangan_lainnya) }}"
                                        />
                                        @error('keterangan_lainnya')
                                        <div class="invalid-feedback">Please enter the field Keterangan Akses Lainnya</div>
                                        @enderror
                                    </div>
        
                                    {{-- Kebutuhan Permintaan --}}
                                    <div class="col-md-12">
                                        <div class="col-md-5">
                                            <label for="kebutuhan_permintaan" class="form-label">Kebutuhan Permintaan</label>
                                            <input
                                                type="text"
                                                class="form-control @error('kebutuhan_permintaan') is-invalid @enderror"
                                                name="kebutuhan_permintaan"
                                                id="kebutuhan_permintaan"
                                                placeholder="Jelaskan kebutuhan permintaan hak akses..."
                                                aria-label="Kebutuhan Permintaan"
                                                value="{{ old('kebutuhan_permintaan', $accessRequest->kebutuhan_permintaan) }}"
                                                required
                                            />
                                            @error('kebutuhan_permintaan')
                                            <div class="invalid-feedback">Please enter the field Kebutuhan Permintaan</div>
                                            @enderror
                                        </div>
                                    </div>
        
                                    {{-- Sifat Akses --}}
                                    <div class="col-md-3">
                                        <label for="sifat_akses" class="form-label">Sifat Akses</label>
                                        <select name="sifat_akses" class="form-select @error('sifat_akses') is-invalid @enderror" aria-label="Select characteristics" required>
                                            <option selected disabled>Pilih sifat akses</option>
                                            <option value="rutin" {{ old('sifat_akses', $accessRequest->sifat_akses) == 'rutin' ? 'selected' : '' }}>Rutin (harian/mingguan/bulanan)</option>
                                            <option value="sementara" {{ old('sifat_akses', $accessRequest->sifat_akses) == 'sementara' ? 'selected' : '' }}>Sementara</option>
                                            <option value="selalu_aktif" {{ old('sifat_akses', $accessRequest->sifat_akses) == 'selalu_aktif' ? 'selected' : '' }}>Selalu Aktif</option>
                                        </select>
                                        @error('sifat_akses')
                                        <div class="invalid-feedback">Please select the field Sifat Akses</div>
                                        @enderror
                                    </div>
        
                                    {{-- Waktu Akses --}}
                                    <div class="col-md-3">
                                        <label for="waktu_akses" class="form-label">Waktu Akses</label>
                                        <select name="waktu_akses" id="waktu_akses" class="form-select @error('waktu_akses') is-invalid @enderror" aria-label="Select time" required>
                                            <option selected disabled>Pilih waktu akses</option>
                                            <option value="7x24_jam" {{ old('waktu_akses', $accessRequest->waktu_akses) == '7x24_jam' ? 'selected' : '' }}>7 x 24 Jam</option>
                                            <option value="jam_kerja" {{ old('waktu_akses', $accessRequest->waktu_akses) == 'jam_kerja' ? 'selected' : '' }}>Jam Kerja (08.00 - 17.00)</option>
                                            <option value="lainnya" {{ old('waktu_akses', $accessRequest->waktu_akses) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        @error('waktu_akses')
                                        <div class="invalid-feedback">Please select the field Waktu Akses</div>
                                        @enderror
                                    </div>
        
                                    {{-- Keterangan waktu lainnya (kondisional) --}}
                                    <div class="col-md-3" id="wrapper-keterangan-waktu">
                                        <label for="keterangan_waktu_lainnya" class="form-label">Keterangan Waktu Akses</label>
                                        <input
                                            type="text"
                                            class="form-control @error('keterangan_waktu_lainnya') is-invalid @enderror"
                                            name="keterangan_waktu_lainnya"
                                            id="keterangan_waktu_lainnya"
                                            placeholder="Contoh: Setiap Sabtu & Minggu..."
                                            aria-label="Keterangan Waktu Lainnya"
                                            value="{{ old('keterangan_waktu_lainnya', $accessRequest->keterangan_waktu_lainnya) }}"
                                        />
                                        @error('keterangan_waktu_lainnya')
                                        <div class="invalid-feedback">Please enter the field Keterangan Waktu</div>
                                        @enderror
                                    </div>
        
                                    {{-- Masa Berlaku --}}
                                    <div class="col-md-3">
                                        <label for="masa_berlaku" class="form-label">Masa Berlaku Sampai</label>
                                        <div class="input-group">
                                            <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                            <input
                                                type="text"
                                                class="form-control @error('masa_berlaku') is-invalid @enderror"
                                                name="masa_berlaku"
                                                id="date"
                                                aria-label="Masa Berlaku"
                                                value="{{ old('masa_berlaku', $accessRequest->masa_berlaku) }}"
                                                required
                                            />                                
                                        </div>
                                        @error('masa_berlaku')
                                        <div class="invalid-feedback">Please enter the field Masa Berlaku</div>
                                        @enderror
                                    </div>
        
                                    {{-- File Form Akses --}}
                                    <div class="col-md-4">
                                        <label for="url_form_akses" class="form-label">Upload Formulir</label>
                                        <input
                                            type="file"
                                            class="form-control @error('url_form_akses') is-invalid @enderror"
                                            name="url_form_akses"
                                            id="url_form_akses"
                                            accept=".pdf"
                                        />
                                        <p class="fs-12 p-1 fw-light">Biarkan kosong jika tidak diubah. Allowed Only PDF & Max 5MB</p>
                                        @error('url_form_akses')
                                        <div class="invalid-feedback">Please upload the form file</div>
                                        @enderror
                                    </div>
        
                                    {{-- URL API --}}
                                    <div class="col-md-3">
                                        <label for="url_api" class="form-label">URL API</label>
                                        <input
                                            type="text"
                                            class="form-control @error('url_api') is-invalid @enderror"
                                            name="url_api"
                                            id="url_api"
                                            aria-label="URL API"
                                            value="{{ old('url_api', $accessRequest->url_api) }}"
                                            required
                                        />   
                                        @error('url_api')
                                        <div class="invalid-feedback">Please enter the field URL API</div>
                                        @enderror
                                    </div>
        
                                    {{-- Catatan API --}}
                                    <div class="col-md-3">
                                        <label for="catatan_api" class="form-label">Catatan API</label>
                                        <input
                                            type="text"
                                            class="form-control @error('catatan_api') is-invalid @enderror"
                                            name="catatan_api"
                                            id="catatan_api"
                                            aria-label="Catatan API"
                                            value="{{ old('catatan_api', $accessRequest->catatan_api) }}"
                                        />                                
                                        @error('catatan_api')
                                        <div class="invalid-feedback">Please enter the field Catatan API</div>
                                        @enderror
                                    </div>
                                    {{-- File panduan --}}
                                    <div class="col-md-4">
                                        <label for="url_panduan" class="form-label">Upload Panduan</label>
                                        <input
                                            type="file"
                                            class="form-control @error('url_panduan') is-invalid @enderror"
                                            name="url_panduan"
                                            id="url_panduan"
                                            accept=".pdf"
                                        />
                                        <p class="fs-12 p-2 fw-light">Allowed Only PDF & Max 5MB</p>
                                        @error('url_panduan')
                                        <div class="invalid-feedback">Please upload the guide file</div>
                                        @enderror
                                    </div>

                                    {{-- File formulir saat ini --}}
                                    @if ($accessRequest->url_form_akses != null)
                                    <div class="col-md-12">
                                        <small class="text-muted d-block">Formulir Permohonan Hak Akses:</small>
                                        <div class="show-pdf ratio ratio-16x9 mt-2">
                                            <embed 
                                            src="{{ asset('storage/' . $accessRequest->url_form_akses) }}" 
                                            type="application/pdf" 
                                            class="rounded border" 
                                            />
                                        </div>
                                    </div>
                                    @endif

                                    {{-- File panduan saat ini --}}
                                    @if ($accessRequest->url_panduan != null)
                                    <div class="col-md-12">
                                        <small class="text-muted d-block">File Panduan:</small>
                                        <div class="show-pdf ratio ratio-16x9 mt-2">
                                            <embed 
                                            src="{{ asset('storage/' . $accessRequest->url_panduan) }}" 
                                            type="application/pdf" 
                                            class="rounded border" 
                                            />
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Status Permohonan --}}
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Status Permohonan</label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror" aria-label="Select status" required>
                                            <option selected disabled>Pilih status permohonan</option>
                                            <option value="pending" {{ old('status', $accessRequest->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ old('status', $accessRequest->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ old('status', $accessRequest->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">Please select the field Status Permohonan</div>
                                        @enderror
                                    </div>

                                    {{-- Status Keaktifan --}}
                                    <div class="col-md-3">
                                        <label for="aktif" class="form-label">Status Aktif</label>
                                        <select name="aktif" class="form-select @error('aktif') is-invalid @enderror" aria-label="Select active" required>
                                            <option selected disabled>Pilih status aktif</option>
                                            <option value="T" {{ old('aktif', $accessRequest->aktif) == 'T' ? 'selected' : '' }}>Inactive</option>
                                            <option value="Y" {{ old('aktif', $accessRequest->aktif) == 'Y' ? 'selected' : '' }}>Active</option>
                                        </select>
                                        @error('aktif')
                                        <div class="invalid-feedback">Please select the field Status Aktif</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden Checkbox Ketentuan --}}
                            <input type="hidden" name="setuju_ketentuan" value="1">
                            

                            <div class="col-12 d-flex align-items-center justify-content-center flex-wrap gap-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                <a href="{{ route('accessRequest.index') }}" class="btn btn-light me-2">Kembali</a>
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

{{-- Script form access --}}
<script src="{{ asset('assets/js/formAccess.js') }}"></script>

<!-- Date & Time Picker JS -->
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/date&time_pickers.js') }}"></script>
    
@endpush
