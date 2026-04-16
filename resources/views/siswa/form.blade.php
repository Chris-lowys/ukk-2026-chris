@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        {{-- Header Card --}}
        <div class="text-center mb-4">
            <div class="fs-1">📝</div>
            <h4 class="fw-bold mb-1" style="color: #ffffff;">Form Pengaduan Sarana</h4>
            <p class="mb-0" style="color: #ffffff;">Laporkan kerusakan atau kekurangan fasilitas sekolah</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                {{-- Notifikasi Error Validasi --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>⚠️ Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('kirim') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Toggle Anonim --}}
<div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="anonim" name="anonim"
            {{ old('anonim') ? 'checked' : '' }}
            onchange="toggleNIS(this)">
        <label class="form-check-label fw-semibold" for="anonim">
            ⚫ Kirim sebagai Anonim (tanpa NIS)
        </label>
    </div>
    <small class="text-muted">Centang jika tidak ingin mencantumkan identitas</small>
</div>

{{-- Pilih NIS (disembunyikan jika anonim) --}}
<div class="mb-3" id="nisField" {{ old('anonim') ? 'style=display:none' : '' }}>
    <label class="form-label fw-semibold">
        👤 NIS Siswa <span class="text-danger">*</span>
    </label>
    <select name="nis" class="form-select" id="nisSelect">
        <option value="">-- Pilih NIS --</option>
        @foreach($siswa as $s)
            <option value="{{ $s->nis }}"
                {{ old('nis') == $s->nis ? 'selected' : '' }}>
                {{ $s->nis }} - Kelas {{ $s->kelas }}
            </option>
        @endforeach
    </select>
</div>

<script>
function toggleNIS(checkbox) {
    const nisField = document.getElementById('nisField');
    const nisSelect = document.getElementById('nisSelect');
    if (checkbox.checked) {
        nisField.style.display = 'none';
        nisSelect.value = '';        // kosongkan pilihan
    } else {
        nisField.style.display = '';
    }
}
</script>

                    {{-- Pilih Kategori --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            🗂️ Kategori Pengaduan <span class="text-danger">*</span>
                        </label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id_kategori }}"
                                    {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->ket_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            📍 Lokasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="lokasi"
                            class="form-control"
                            placeholder="Contoh: Ruang Kelas 10A, Lab Komputer..."
                            value="{{ old('lokasi') }}"
                            maxlength="50" required>
                        <small class="text-muted">Maksimal 50 karakter</small>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            📄 Keterangan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="ket"
                            class="form-control"
                            placeholder="Contoh: Kursi rusak, AC tidak berfungsi..."
                            value="{{ old('ket') }}"
                            maxlength="50" required>
                        <small class="text-muted">Maksimal 50 karakter</small>
                    </div>

                    {{-- Lampiran --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            📎 Lampiran
                            <span class="text-muted fw-normal">(opsional)</span>
                        </label>
                        <input type="file" name="lampiran" class="form-control">
                        <small class="text-muted">
                            Format: JPG, PNG, PDF, DOC, XLS. Maks 5MB.
                        </small>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            📤 Kirim Pengaduan
                        </button>
                        <a href="{{ route('cek.form') }}" class="btn btn-outline-secondary">
                            🔍 Cek Status Pengaduan
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- Info --}}
        <div class="text-center mt-3">
            <small class="text-muted">
                Pengaduan akan diproses oleh admin secepatnya
            </small>
        </div>
    </div>
</div>

@endsection