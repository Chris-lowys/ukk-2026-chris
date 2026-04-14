@extends('layouts.admin')
@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">📊 Dashboard Pengaduan</h4>
        <p class="text-muted mb-0">Ringkasan data aspirasi sarana sekolah</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <span class="text-muted small">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
        <a href="{{ route('admin.export.excel') }}" class="btn btn-success btn-sm">
            📊 Export Excel
        </a>
        <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger btn-sm">
            📄 Export PDF
        </a>
    </div>
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

    {{-- Filter & Pencarian --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.dashboard') }}" method="GET">
            <div class="row g-2 align-items-end">

                {{-- Search --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold mb-1">🔍 Pencarian</label>
                    <input type="text" name="search"
                        class="form-control"
                        placeholder="Cari NIS, lokasi, keterangan..."
                        value="{{ request('search') }}">
                </div>

                {{-- Filter Status --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold mb-1">📌 Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="Menunggu"  {{ request('status') == 'Menunggu' ? 'selected' : '' }}>
                            ⏳ Menunggu
                        </option>
                        <option value="Diproses"  {{ request('status') == 'Diproses' ? 'selected' : '' }}>
                            🔄 Diproses
                        </option>
                        <option value="Selesai"   {{ request('status') == 'Selesai'  ? 'selected' : '' }}>
                            ✅ Selesai
                        </option>
                    </select>
                </div>

                {{-- Filter Kategori --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold mb-1">🗂️ Kategori</label>
                    <select name="id_kategori" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoriList as $k)
                            <option value="{{ $k->id_kategori }}"
                                {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->ket_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="col-md-2">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-primary w-100">
                            Cari
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            ✕
                        </a>
                    </div>
                </div>

            </div>
        </form>

        {{-- Info hasil filter --}}
        @if(request()->hasAny(['search', 'status', 'id_kategori']))
            <div class="mt-2 pt-2 border-top">
                <small class="text-muted">
                    Menampilkan <strong>{{ $data->count() }}</strong> hasil
                    @if(request('search'))
                        untuk pencarian "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('status'))
                        dengan status <strong>{{ request('status') }}</strong>
                    @endif
                    @if(request('id_kategori'))
                        pada kategori <strong>{{ $kategoriList->where('id_kategori', request('id_kategori'))->first()?->ket_kategori }}</strong>
                    @endif
                    — <a href="{{ route('admin.dashboard') }}">Tampilkan semua</a>
                </small>
            </div>
        @endif

    </div>
</div>

    {{-- Kartu Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fs-1 mb-2">📋</div>
                    <h2 class="fw-bold text-primary mb-0">{{ $total }}</h2>
                    <small class="text-muted">Total Aspirasi</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fs-1 mb-2">⏳</div>
                    <h2 class="fw-bold text-warning mb-0">{{ $menunggu }}</h2>
                    <small class="text-muted">Menunggu</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fs-1 mb-2">🔄</div>
                    <h2 class="fw-bold text-info mb-0">{{ $proses }}</h2>
                    <small class="text-muted">Diproses</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <div class="fs-1 mb-2">✅</div>
                    <h2 class="fw-bold text-success mb-0">{{ $selesai }}</h2>
                    <small class="text-muted">Selesai</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="row g-3 mb-4">

        {{-- Grafik Line: Per Bulan --}}
        <div class="col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold border-bottom">
                    📈 Tren Aspirasi 6 Bulan Terakhir
                </div>
                <div class="card-body">
                    <canvas id="grafikBulan" height="120"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Donut: Per Kategori --}}
        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold border-bottom">
                    🗂️ Aspirasi per Kategori
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="grafikKategori" height="180"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Bar: Status --}}
        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold border-bottom">
                    📊 Perbandingan Status
                </div>
                <div class="card-body">
                    <canvas id="grafikStatus" height="180"></canvas>
                </div>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold border-bottom">
                    📌 Ringkasan Cepat
                </div>
                <div class="card-body">
                    @php
                        $persen = $total > 0 ? round(($selesai / $total) * 100) : 0;
                    @endphp

                    <p class="fw-semibold mb-1">Tingkat Penyelesaian</p>
                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar bg-success"
                            id="progressSelesai"
                            data-width="{{ $persen }}">
                            {{ $persen }}%
                        </div>
                    </div>

                    <div class="row text-center g-2 mt-1">
                        <div class="col-4">
                            <div class="p-2 rounded bg-warning bg-opacity-10">
                                <div class="fw-bold text-warning">
                                    {{ $total > 0 ? round(($menunggu / $total) * 100) : 0 }}%
                                </div>
                                <small class="text-muted">Menunggu</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-info bg-opacity-10">
                                <div class="fw-bold text-info">
                                    {{ $total > 0 ? round(($proses / $total) * 100) : 0 }}%
                                </div>
                                <small class="text-muted">Diproses</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-success bg-opacity-10">
                                <div class="fw-bold text-success">{{ $persen }}%</div>
                                <small class="text-muted">Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Aspirasi --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold border-bottom d-flex justify-content-between align-items-center">
            <span>📋 Daftar Aspirasi</span>
            <span class="badge bg-primary">{{ $total }} total</span>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $d->nis }}</td>
                        <td>{{ $d->siswa->kelas ?? '-' }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $d->kategori->ket_kategori ?? '-' }}
                            </span>
                        </td>
                        <td>{{ $d->lokasi }}</td>
                        <td>{{ $d->ket }}</td>
                        <td>
                            @if($d->status == 'Menunggu')
                                <span class="badge bg-warning text-dark">⏳ Menunggu</span>
                            @elseif($d->status == 'Diproses')
                                <span class="badge bg-info">🔄 Diproses</span>
                            @else
                                <span class="badge bg-success">✅ Selesai</span>
                            @endif
                        </td>
                        <td>{{ $d->feedback ?? '-' }}</td>
                        <td>
                            {{-- Tombol Detail --}}
                            <a href="{{ route('admin.aspirasi.show', $d->id_aspirasi) }}"
                                class="btn btn-sm btn-info mb-1">
                                🔍 Detail
                            </a>

                            {{-- Tombol Update --}}
                            <button class="btn btn-sm btn-primary mb-1"
                                data-bs-toggle="modal"
                                data-bs-target="#modalUpdate{{ $d->id_aspirasi }}">
                                ✏️ Update
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.aspirasi.destroy', $d->id_aspirasi) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus aspirasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Update --}}
                    <div class="modal fade" id="modalUpdate{{ $d->id_aspirasi }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Update Aspirasi #{{ $d->id_aspirasi }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.aspirasi.update', $d->id_aspirasi) }}"
                                    method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="Menunggu" {{ $d->status == 'Menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                                                <option value="Diproses" {{ $d->status == 'Diproses' ? 'selected' : '' }}>🔄 Diproses</option>
                                                <option value="Selesai"  {{ $d->status == 'Selesai'  ? 'selected' : '' }}>✅ Selesai</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Feedback</label>
                                            <textarea name="feedback" class="form-control" rows="3"
                                                placeholder="Tuliskan feedback...">{{ $d->feedback }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">💾 Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal --}}

                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            😕 Belum ada aspirasi masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Data untuk Chart (dipisah dari JS agar VS Code tidak bingung) --}}
<script>
    const chartData = {
        labelBulan:    {!! json_encode($labelBulan) !!},
        dataBulan:     {!! json_encode($dataBulan) !!},
        labelKategori: {!! json_encode($labelKategori) !!},
        dataKategori:  {!! json_encode($dataKategori) !!},
        menunggu:      {{ $menunggu }},
        proses:        {{ $proses }},
        selesai:       {{ $selesai }}
    };
</script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Progress Bar
    document.addEventListener('DOMContentLoaded', function() {
        const bar = document.getElementById('progressSelesai');
        if(bar) bar.style.width = bar.dataset.width + '%';
    });

    // Grafik 1: Line - Tren Per Bulan
    new Chart(document.getElementById('grafikBulan'), {
        type: 'line',
        data: {
            labels: chartData.labelBulan,
            datasets: [{
                label: 'Jumlah Aspirasi',
                data: chartData.dataBulan,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0d6efd',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Grafik 2: Donut - Per Kategori
    new Chart(document.getElementById('grafikKategori'), {
        type: 'doughnut',
        data: {
            labels: chartData.labelKategori,
            datasets: [{
                data: chartData.dataKategori,
                backgroundColor: [
                    '#0d6efd','#6f42c1','#d63384','#fd7e14',
                    '#20c997','#0dcaf0','#ffc107','#198754'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 15 } }
            }
        }
    });

    // Grafik 3: Bar - Perbandingan Status
    new Chart(document.getElementById('grafikStatus'), {
        type: 'bar',
        data: {
            labels: ['Menunggu', 'Diproses', 'Selesai'],
            datasets: [{
                label: 'Jumlah',
                data: [chartData.menunggu, chartData.proses, chartData.selesai],
                backgroundColor: ['#ffc107', '#0dcaf0', '#198754'],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>

@endsection