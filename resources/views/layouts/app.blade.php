<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Sarana Sekolah SMKN 1 BUNTOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('images/bg1.JPG') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Overlay gelap */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(78, 78, 78, 0.45);
            z-index: 0;
        }

        nav, main, footer {
            position: relative;
            z-index: 1;
        }

        main {
            flex: 1;
        }

        /* Card lebih solid agar tidak tembus background */
        .card {
            background: rgba(255, 255, 255, 0.97);
            transition: box-shadow 0.2s ease;
        }
        .card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
        }

        /* Brand lebih kecil di mobile */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 0.75rem;
                letter-spacing: 0;
            }
            .navbar-brand span {
                display: none;
            }
        }

        /* Tombol navbar di mobile */
        @media (max-width: 991px) {
            .navbar-nav-custom {
                padding: 10px 0;
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                justify-content: center;
            }
            .navbar-nav-custom .btn {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
        }

        /* Tabel scroll di mobile */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Input & select lebih besar di mobile */
        @media (max-width: 576px) {
            .form-control, .form-select {
                font-size: 1rem;
                padding: 10px 12px;
            }
        }

        footer {
            background-color: rgba(33, 37, 41, 0.92);
            color: #adb5bd;
            padding: 16px 0;
            text-align: center;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark shadow"
    style="background: rgba(13, 110, 253, 0.92);">
    <div class="container">

        {{-- Brand dengan Logo --}}
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/logo_smkn1buntok.png') }}"
                alt="Logo SMKN 1 BUNTOK"
                style="height: 55px; width: auto;">
            <div class="d-flex flex-column">
                <span style="font-size: 0.95rem; line-height: 1.2;">
                    PENGADUAN SARANA
                </span>
                <span style="font-size: 0.75rem; opacity: 0.85; font-weight: 400;">
                    SMKN 1 BUNTOK
                </span>
            </div>
        </a>

        {{-- Toggle mobile --}}
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#appNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse justify-content-end" id="appNavbar">
            <div class="navbar-nav-custom d-flex gap-2 mt-2 mt-lg-0">
                <a href="{{ route('home') }}"
                    class="btn btn-sm {{ request()->is('/') ? 'btn-light' : 'btn-outline-light' }}">
                    📋 Daftar Pengaduan
                </a>

                {{-- ✅ Diubah dari warning ke outline-light --}}
                <a href="{{ route('form') }}"
                    class="btn btn-sm {{ request()->is('form') ? 'btn-light' : 'btn-outline-light' }}">
                    📝 Input Pengaduan
                </a>

                {{-- ✅ Diubah dari success ke outline-light --}}
                <a href="{{ route('cek.form') }}"
                    class="btn btn-sm {{ request()->is('cek') ? 'btn-light' : 'btn-outline-light' }}">
                    🔍 Cek Status
                </a>

                <a href="{{ route('admin.login') }}"
                    class="btn btn-sm btn-dark">
                    🔐 Login Admin
                </a>
            </div>
        </div>

    </div>
</nav>

{{-- Konten Utama --}}
<main class="container mt-4 mb-5 px-3 px-md-4">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>