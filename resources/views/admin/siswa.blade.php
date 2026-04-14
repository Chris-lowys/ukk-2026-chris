@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Data Siswa</h3>

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

    {{-- Form Tambah Siswa --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Tambah Siswa</div>
        <div class="card-body">
            <form action="{{ route('admin.siswa.store') }}" method="POST" class="row g-2">
                @csrf
                <div class="col-md-5">
                    <input type="number" name="nis" class="form-control"
                        placeholder="NIS" required>
                    @error('nis')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <input type="text" name="kelas" class="form-control"
                        placeholder="Kelas (contoh: X-A)" required maxlength="10">
                    @error('kelas')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success w-100">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Siswa --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->kelas }}</td>
                        <td>
                            {{-- Tombol Edit (trigger modal) --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $s->nis }}">
                                ✏️ Edit
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.siswa.destroy', $s->nis) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Edit Siswa --}}
                    <div class="modal fade" id="modalEdit{{ $s->nis }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Siswa - NIS {{ $s->nis }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.siswa.update', $s->nis) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">NIS</label>
                                            <input type="number" class="form-control"
                                                value="{{ $s->nis }}" disabled>
                                            <small class="text-muted">NIS tidak dapat diubah</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Kelas</label>
                                            <input type="text" name="kelas"
                                                class="form-control"
                                                value="{{ $s->kelas }}"
                                                required maxlength="10">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal --}}

                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data siswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection