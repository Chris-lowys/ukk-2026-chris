@extends('layouts.app')
@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
       <h4 class="fw-bold mb-1" style="color: #ffffff;">📋 Daftar Pengaduan Sarana</h4>
        <p class="mb-0" style="color: #ffffff;">Menampilkan seluruh pengaduan yang masuk</p>
    </div>
    <a href="{{ route('form') }}" class="btn btn-primary">
        📝 Buat Pengaduan
    </a>
</div>

{{-- Kartu Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 mb-1">📋</div>
            <h3 class="fw-bold text-primary mb-0">{{ $data->count() }}</h3>
            <small class="text-muted">Total Pengaduan</small>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 mb-1">⏳</div>
            <h3 class="fw-bold text-warning mb-0">
                {{ $data->where('status', 'Menunggu')->count() }}
            </h3>
            <small class="text-muted">Menunggu</small>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 mb-1">✅</div>
            <h3 class="fw-bold text-success mb-0">
                {{ $data->where('status', 'Selesai')->count() }}
            </h3>
            <small class="text-muted">Selesai</small>
        </div>
    </div>
</div>

{{-- Tabel Pengaduan --}}
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <span class="fw-semibold">📋 Data Pengaduan</span>
        <span class="badge bg-primary">{{ $data->count() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width:50px">No</th>
                        <th>NIS</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $d->nis }}</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">
                                {{ $d->kategori->ket_kategori ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">📍</small> {{ $d->lokasi }}
                        </td>
                        <td>{{ $d->ket }}</td>
                        <td class="text-center">
                            @if($d->status == 'Menunggu')
                                <span class="badge bg-warning text-dark rounded-pill">⏳ Menunggu</span>
                            @elseif($d->status == 'Diproses')
                                <span class="badge bg-info rounded-pill">🔄 Diproses</span>
                            @else
                                <span class="badge bg-success rounded-pill">✅ Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <div class="fs-1 mb-2">📭</div>
                                <p class="mb-1 fw-semibold">Belum ada pengaduan</p>
                                <small>Pengaduan yang masuk akan tampil di sini</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection