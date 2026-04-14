@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Data Kategori</h3>

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

    {{-- Form Tambah Kategori --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Kategori</div>
        <div class="card-body">
            <form action="{{ route('admin.kategori.store') }}" method="POST" class="row g-2">
                @csrf
                <div class="col-md-9">
                    <input type="text" name="ket_kategori" class="form-control"
                        placeholder="Nama Kategori" required maxlength="30">
                    @error('ket_kategori')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Kategori --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $k->ket_kategori }}</td>
                        <td>
                            {{-- Tombol Edit (trigger modal) --}}
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $k->id_kategori }}">
                                ✏️ Edit
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Edit Kategori --}}
                    <div class="modal fade" id="modalEdit{{ $k->id_kategori }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.kategori.update', $k->id_kategori) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <label class="form-label">Nama Kategori</label>
                                        <input type="text" name="ket_kategori"
                                            class="form-control"
                                            value="{{ $k->ket_kategori }}"
                                            required maxlength="30">
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
                        <td colspan="3" class="text-center text-muted">Belum ada kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection