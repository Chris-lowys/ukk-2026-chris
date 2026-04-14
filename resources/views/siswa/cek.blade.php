@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">

        {{-- Header --}}
        <div class="text-center mb-4">
            <div class="fs-1">🔍</div>
            <h4 class="fw-bold mb-1" style="color: #ffffff;">Cek Status Pengaduan</h4>
            <p class="mb-0" style="color: #ffffff;">Masukkan NIS untuk melihat status pengaduanmu</p>
        </div>

        {{-- Form Cek Status --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('cek.status') }}" method="POST">
                    @csrf
                    <label class="form-label fw-semibold">👤 Pilih NIS</label>
                    <div class="input-group">
                        <select name="nis" class="form-select" required>
                            <option value="">-- Pilih NIS --</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->nis }}"
                                    {{ isset($data) && request()->nis == $s->nis ? 'selected' : '' }}>
                                    {{ $s->nis }} - Kelas {{ $s->kelas }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary px-4">
                            Cek
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Hasil Pencarian --}}
        @if(isset($data))
            @if($data->count() == 0)
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="fs-1 mb-2">📭</div>
                        <h5 class="fw-semibold">Tidak Ada Pengaduan</h5>
                        <p class="text-muted mb-0">
                            Belum ada pengaduan yang ditemukan untuk NIS ini
                        </p>
                    </div>
                </div>
            @else
                {{-- Info jumlah --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-semibold">📋 Hasil Pengaduan</span>
                    <span class="badge bg-primary rounded-pill">
                        {{ $data->count() }} pengaduan
                    </span>
                </div>

                {{-- List Pengaduan --}}
                <div class="d-flex flex-column gap-3">
                    @foreach($data as $d)
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            {{-- Baris atas: kategori + status --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                    <span class="badge bg-secondary rounded-pill">
                                        {{ $d->kategori->ket_kategori ?? '-' }}
                                    </span>
                                    <small class="text-muted">
                                        📍 {{ $d->lokasi }}
                                    </small>
                                </div>
                                @if($d->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark rounded-pill">⏳ Menunggu</span>
                                @elseif($d->status == 'Diproses')
                                    <span class="badge bg-info rounded-pill">🔄 Diproses</span>
                                @else
                                    <span class="badge bg-success rounded-pill">✅ Selesai</span>
                                @endif
                            </div>

                            {{-- Keterangan --}}
                            <p class="mb-2 text-dark">
                                <strong>Keterangan:</strong> {{ $d->ket }}
                            </p>

                            {{-- Tanggal --}}
                            <small class="text-muted">
                                🕐 {{ $d->created_at->format('d M Y, H:i') }}
                            </small>

                            {{-- Feedback --}}
                            @if($d->feedback)
                                <div class="alert alert-info py-2 px-3 mb-0 mt-3">
                                    <small>
                                        <strong>💬 Feedback Admin:</strong>
                                        {{ $d->feedback }}
                                    </small>
                                </div>
                            @else
                                <div class="mt-2">
                                    <small class="text-muted fst-italic">
                                        💬 Belum ada feedback dari admin
                                    </small>
                                </div>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- Tombol kembali --}}
        <div class="text-center mt-4">
            <a href="{{ route('form') }}" class="btn btn-outline-primary btn-sm">
                ← Kembali ke Form Pengaduan
            </a>
        </div>

    </div>
</div>

@endsection