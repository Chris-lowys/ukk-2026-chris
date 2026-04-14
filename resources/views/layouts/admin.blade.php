<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengaduan Sarana SMKN 1 BUNTOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Navbar brand lebih kecil di mobile */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 0.85rem;
            }
            .navbar-brand span {
                display: none;
            }
        }

        /* Navbar tombol wrap di mobile */
        .nav-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        @media (max-width: 768px) {
            .nav-buttons {
                margin-top: 10px;
                justify-content: center;
                width: 100%;
            }
            .nav-buttons .btn {
                font-size: 0.75rem;
                padding: 4px 8px;
            }
        }

        /* Tabel scroll di mobile */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Card lebih rapi di mobile */
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

        footer {
            background-color: #343a40;
            color: #adb5bd;
            padding: 16px 0;
            text-align: center;
            font-size: 0.85rem;
        }

        @media (max-width: 576px) {
            footer {
                font-size: 0.75rem;
                padding: 12px 8px;
            }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-3">

        {{-- Brand --}}
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            🏫 <span>Admin Panel</span> SMKN 1 BUNTOK
        </a>

        {{-- Toggle mobile --}}
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="adminNavbar">
            <div class="nav-buttons ms-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="btn btn-sm {{ request()->is('admin/dashboard*') ? 'btn-light' : 'btn-outline-light' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.kategori.index') }}"
                    class="btn btn-sm {{ request()->is('admin/kategori*') ? 'btn-warning' : 'btn-outline-warning' }}">
                    🗂️ Kategori
                </a>
                <a href="{{ route('admin.siswa.index') }}"
                    class="btn btn-sm {{ request()->is('admin/siswa*') ? 'btn-info' : 'btn-outline-info' }}">
                    👥 Siswa
                </a>
                <a href="{{ route('admin.logout') }}"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('Yakin ingin logout?')">
                    🚪 Logout
                </a>
            </div>
        </div>

    </div>
</nav>

{{-- Konten Utama --}}
<main class="container-fluid mt-4 px-3 px-md-4 mb-5">
    {{-- Flash message global --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            ⚠️ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

{{-- Footer --}}
<footer>
    <div class="container">
        <p class="mb-0">
            © {{ date('Y') }} Sistem Pengaduan Sarana Sekolah SMKN 1 BUNTOK.
            All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>