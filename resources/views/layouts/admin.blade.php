<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Admin - Pengaduan Sarana SMKN 1 BUNTOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --dark-color: #212529;
        }

        body {
            background-image: url('{{ asset('images/bg1.JPG') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            /* Mencegah scroll horizontal seluruh halaman */
            overflow-x: hidden; 
            width: 100%;
        }

        main {
            flex: 1;
            width: 100%;
        }

        /* Perbaikan Logo agar tidak mendorong navbar */
        .navbar-brand img {
            height: 45px; /* Sedikit lebih kecil agar muat di mobile */
            width: auto;
        }

        @media (max-width: 576px) {
            .navbar-brand img { height: 35px; }
            .brand-text-main { font-size: 0.85rem !important; }
            .brand-text-sub { font-size: 0.65rem !important; }
        }

        /* Nav buttons agar rapi saat collapse maupun tidak */
        .nav-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 10px 0;
        }

        @media (max-width: 991px) {
            .nav-buttons {
                justify-content: flex-start;
                border-top: 1px solid rgba(255,255,255,0.1);
                margin-top: 10px;
            }
            .nav-buttons .btn {
                width: 100%; /* Tombol jadi penuh di menu mobile toggle */
                text-align: left;
            }
        }

        /* KUNCI RESPONSIF: Wrapper untuk konten yield */
        .content-wrapper {
            background: rgba(255, 255, 255, 0.719); /* Sedikit transparan agar baca teks mudah */
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            overflow-x: hidden; /* Mencegah konten dalam meluap */
        }

        /* Otomatis membuat semua tabel di dalam content-wrapper bisa di-scroll */
        .table-responsive {
            margin-bottom: 1rem;
            border: none;
        }

        footer {
            background-color: var(--dark-color);
            color: #adb5bd;
            padding: 20px 0;
            margin-top: auto;
            width: 100%;
        }

        /* Utility class untuk teks yang terlalu panjang di tabel */
        .text-truncate-mobile {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-3">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/logo_smkn1buntok.png') }}" alt="Logo">
            <div class="d-flex flex-column">
                <span class="brand-text-main" style="font-size: 1.0rem; line-height: 1.2;">Admin Dashboard</span>
                <span class="brand-text-sub" style="font-size: 0.75rem; opacity: 0.85; font-weight: 400;">SMKN 1 BUNTOK</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <div class="nav-buttons ms-auto">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm {{ request()->is('admin/dashboard*') ? 'btn-light' : 'btn-outline-light' }}">📊 Dashboard</a>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm {{ request()->is('admin/kategori*') ? 'btn-warning' : 'btn-outline-warning' }}">🗂️ Kategori</a>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm {{ request()->is('admin/siswa*') ? 'btn-info' : 'btn-outline-info' }}">👥 Siswa</a>
                <a href="{{ route('admin.logout') }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin logout?')">🚪 Logout</a>
            </div>
        </div>
    </div>
</nav>

<main class="container-fluid mt-3 mt-md-4 px-2 px-md-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            {{-- Flash message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-2">
                    ✅ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Container Putih untuk Konten --}}
            <div class="content-wrapper mx-1 mx-md-0">
                @yield('content')
            </div>
        </div>
    </div>
</main>

<footer>
    <div class="container text-center">
        <p class="mb-0 small">
            © {{ date('Y') }} Sistem Pengaduan SMKN 1 BUNTOK.<br class="d-block d-sm-none">
            All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>