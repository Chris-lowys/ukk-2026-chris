@extends('layouts.admin')
@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">📋 Detail Aspirasi</h4>
            <p class="text-muted mb-0">ID Aspirasi: #{{ $aspirasi->id_aspirasi }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Kolom Kiri: Informasi Aspirasi --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-semibold">
                    📄 Informasi Pengaduan
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="35%" class="text-muted fw-semibold">NIS Siswa</td>
                            <td>{{ $aspirasi->nis }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Kelas</td>
                            <td>{{ $aspirasi->siswa->kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Kategori</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $aspirasi->kategori->ket_kategori ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Lokasi</td>
                            <td>📍 {{ $aspirasi->lokasi }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Keterangan</td>
                            <td>{{ $aspirasi->ket }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Tanggal Masuk</td>
                            <td>{{ $aspirasi->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Terakhir Update</td>
                            <td>{{ $aspirasi->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Status</td>
                            <td>
                                @if($aspirasi->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">⏳ Menunggu</span>
                                @elseif($aspirasi->status == 'Diproses')
                                    <span class="badge bg-info">🔄 Diproses</span>
                                @else
                                    <span class="badge bg-success">✅ Selesai</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Feedback</td>
                            <td>
                                @if($aspirasi->feedback)
                                    <div class="alert alert-info py-2 mb-0">
                                        {{ $aspirasi->feedback }}
                                    </div>
                                @else
                                    <span class="text-muted">Belum ada feedback</span>
                                @endif
                            </td>
                        </tr>
                        {{-- Lampiran ditampilkan di dalam tabel informasi --}}
                        <tr>
                            <td class="text-muted fw-semibold">Lampiran</td>
                            <td>
                                @if($aspirasi->lampiran)
                                    @php
                                        $ext = pathinfo($aspirasi->lampiran, PATHINFO_EXTENSION);
                                    @endphp

                                    {{-- Preview jika gambar --}}
                                    @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']))
                                        <img src="{{ asset('storage/'.$aspirasi->lampiran) }}"
                                            class="img-thumbnail mb-2"
                                            style="max-height: 200px;">
                                        <br>
                                    @endif

                                    {{-- Tombol Lihat --}}
                                    <a href="{{ asset('storage/'.$aspirasi->lampiran) }}"
                                        class="btn btn-sm btn-outline-primary me-1"
                                        target="_blank">
                                        📎 Lihat Lampiran
                                    </a>

                                    {{-- Tombol Hapus Lampiran --}}
                                    <form action="{{ route('admin.aspirasi.lampiran.hapus', $aspirasi->id_aspirasi) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus lampiran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            🗑️ Hapus Lampiran
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Belum ada lampiran</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form-form Aksi --}}
        <div class="col-md-5">

            {{-- Form Update Status & Feedback --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success text-white fw-semibold">
                    ✏️ Update Status & Feedback
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.aspirasi.update', $aspirasi->id_aspirasi) }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Menunggu"
                                    {{ $aspirasi->status == 'Menunggu' ? 'selected' : '' }}>
                                    ⏳ Menunggu
                                </option>
                                <option value="Diproses"
                                    {{ $aspirasi->status == 'Diproses' ? 'selected' : '' }}>
                                    🔄 Diproses
                                </option>
                                <option value="Selesai"
                                    {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>
                                    ✅ Selesai
                                </option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Feedback</label>
                            <textarea name="feedback" class="form-control" rows="4"
                                placeholder="Tuliskan feedback atau tindakan yang sudah diambil...">{{ $aspirasi->feedback }}</textarea>
                            <small class="text-muted">Maksimal 255 karakter</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            💾 Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Form Upload Lampiran --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-warning text-dark fw-semibold">
                    📎 Upload Lampiran
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.aspirasi.lampiran', $aspirasi->id_aspirasi) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih File</label>
                            <input type="file" name="lampiran" class="form-control" required>
                            <small class="text-muted">
                                Semua format diizinkan. Maks 5MB.
                                @if($aspirasi->lampiran)
                                    <span class="text-warning d-block mt-1">
                                        ⚠️ Upload baru akan mengganti lampiran lama.
                                    </span>
                                @endif
                            </small>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            📤 Upload Lampiran
                        </button>
                    </form>
                </div>
            </div>

            {{-- Zona Berbahaya: Hapus Aspirasi --}}
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h6 class="text-danger fw-semibold mb-2">⚠️ Zona Berbahaya</h6>
                    <p class="text-muted small mb-3">
                        Menghapus aspirasi ini bersifat permanen dan tidak bisa dikembalikan.
                    </p>
                    <form action="{{ route('admin.aspirasi.destroy', $aspirasi->id_aspirasi) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus aspirasi ini? Tindakan ini tidak bisa dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            🗑️ Hapus Aspirasi Ini
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection