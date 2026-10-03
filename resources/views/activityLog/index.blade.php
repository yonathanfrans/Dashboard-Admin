@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('components.page-header', [
            'title' => 'Activity Log',
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
                        <form action="{{ route('activityLog.index') }}" method="GET" class="mb-3 d-flex justify-content-between align-items-center flex-wrap px-3">
                            {{-- Filter search --}}
                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"> <i class="ri-search-line"></i> </div>
                                    <input 
                                        type="search" 
                                        name="search" 
                                        class="form-control" 
                                        placeholder="Cari nama, email, deskripsi..." 
                                        value="{{ request('search') }}"
                                    >
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                {{-- Filter rentang tanggal --}}
                                <div class="input-group">
                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                    <input 
                                        type="text" 
                                        name="date_range"
                                        class="form-control" 
                                        id="daterange" 
                                        placeholder="Pilih rentang tanggal..."
                                        value="{{ request('date_range') }}"
                                    >
                                </div>
                                {{-- Tombol Submit & Reset --}}
                                <button type="submit" class="btn btn-primary">Filter</button>
                                @if(request('search') || request('date_range'))
                                <a href="{{ route('activityLog.index') }}" class="btn btn-light">Reset</a>
                                @endif
                            </div>
                        </form>

                        <div class="tab-content">
                            <div class="tab-pane border-0 p-0 active" id="tab5">
                                {{-- Table data --}}
                                <div class="table-responsive overflow-x-scroll">
                                    <table class="table table-bordered text-nowrap text-start">
                                        <thead class="border-top">
                                            <tr>
                                                <th class="text-center" scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Deskripsi</th>
                                                <th scope="col">Date Time</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($activityLogs as $item)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $activityLogs->firstItem() + $loop->index }}</th>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ Str::limit($item->deskripsi, 80) }}</td>
                                                <td>{{ $item->date_created->format('d-m-Y H:i:s') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    Belum ada Activity Log.
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
                            @if ($activityLogs->total() < 11) 
                            <div class="col-sm-12 col-md-6 my-auto">
                                <span>Showing {{ $activityLogs->firstItem() ?? 0 }} to {{ $activityLogs->lastItem() ?? 0 }} of {{ $activityLogs->total() }} entries</span>
                            </div>
                            @else
                            <div class="col-sm-12">
                                <div class="d-flex flex-row justify-content-end">
                                    {{ $activityLogs->links('pagination::bootstrap-5') }}
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
        id="viewActivityLogModal" 
        tabindex="-1" 
        aria-labelledby="viewActivityLogModalLabel" 
        data-bs-keyboard="false" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                {{-- Modal Header --}}
                <div class="modal-header">
                    <h6 class="modal-title" id="viewActivityLogModalLabel">Lihat Activity Log</h6>
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
                    <button type="submit" class="btn btn-primary">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal View --}}
</div>
<!-- End::app-content -->

@endsection

@push('scripts')

<!-- Date & Time Picker JS -->
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/date&time_pickers.js') }}"></script>
    
@endpush