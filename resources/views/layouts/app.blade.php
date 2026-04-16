<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Sarana Sekolah SMKN 1 BUNTOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('images/bg2.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(97, 97, 97, 0.45);
            z-index: 0;
        }
        nav, main, footer { position: relative; z-index: 1; }
        main { flex: 1; }
        .card {
            background: rgba(255, 255, 255, 0.97);
            transition: box-shadow 0.2s ease;
        }
        .card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important; }
        @media (max-width: 576px) {
            .navbar-brand { font-size: 0.75rem; letter-spacing: 0; }
            .navbar-brand span { display: none; }
        }
        @media (max-width: 991px) {
            .navbar-nav-custom {
                padding: 10px 0;
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                justify-content: center;
            }
            .navbar-nav-custom .btn { font-size: 0.8rem; padding: 5px 10px; }
        }
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        @media (max-width: 576px) {
            .form-control, .form-select { font-size: 1rem; padding: 10px 12px; }
        }
        footer {
            background-color: rgba(33, 37, 41, 0.92);
            color: #adb5bd;
            padding: 16px 0;
            text-align: center;
            font-size: 0.85rem;
        }

        /* ===== MODAL AKSES ADMIN ===== */
        #modalAksesAdmin {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0,0,0,0.6);
            align-items: center;
            justify-content: center;
        }
        #modalAksesAdmin.show {
            display: flex;
        }
        .modal-akses-box {
            background: white;
            border-radius: 16px;
            padding: 32px 28px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            text-align: center;
            animation: fadeInScale 0.2s ease;
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to   { opacity: 1; transform: scale(1); }
        }
        .modal-akses-box h6 {
            font-weight: 700;
            margin-bottom: 4px;
            color: #0d6efd;
        }
        .modal-akses-box p {
            font-size: 0.82rem;
            color: #6c757d;
            margin-bottom: 20px;
        }
        #inputKodeAkses {
            border-radius: 8px;
            border: 1.5px solid #dee2e6;
            padding: 10px 14px;
            width: 100%;
            font-size: 1rem;
            text-align: center;
            letter-spacing: 4px;
            margin-bottom: 12px;
        }
        #inputKodeAkses:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
        }
        #pesanKodeAkses {
            font-size: 0.82rem;
            min-height: 20px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark shadow"
    style="background: rgba(13, 110, 253, 0.92);">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/logo_smkn1buntok.png') }}"
                alt="Logo SMKN 1 BUNTOK"
                style="height: 55px; width: auto;">
            <div class="d-flex flex-column">
                <span style="font-size: 0.95rem; line-height: 1.2;">PENGADUAN SARANA</span>
                <span style="font-size: 0.75rem; opacity: 0.85; font-weight: 400;">SMKN 1 BUNTOK</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#appNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="appNavbar">
            <div class="navbar-nav-custom d-flex gap-2 mt-2 mt-lg-0">
                <a href="{{ route('home') }}"
                    class="btn btn-sm {{ request()->is('/') ? 'btn-light' : 'btn-outline-light' }}">
                    📋 Daftar Pengaduan
                </a>
                <a href="{{ route('cek.form') }}"
                    class="btn btn-sm {{ request()->is('cek') ? 'btn-light' : 'btn-outline-light' }}">
                    🔍 Cek Status
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Modal Akses Admin Rahasia --}}
<div id="modalAksesAdmin">
    <div class="modal-akses-box">
        <h6>🔐 Akses Administrator</h6>
        <p>Masukkan kode akses yang diberikan oleh pengelola sistem</p>
        <input type="password"
               id="inputKodeAkses"
               placeholder="••••••"
               maxlength="20"
               autocomplete="off">
        <div id="pesanKodeAkses" class="text-danger"></div>
        <div class="d-flex gap-2 justify-content-center">
            <button onclick="tutupModalAdmin()"
                    class="btn btn-sm btn-outline-secondary px-3">
                Batal
            </button>
            <button onclick="cekKodeAkses()"
                    class="btn btn-sm btn-primary px-3">
                Masuk
            </button>
        </div>
        <div class="mt-3" style="font-size: 0.75rem; color: #adb5bd;">
            Tekan Esc untuk menutup
        </div>
    </div>
</div>

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

<script>
    // ===== DETEKSI SHORTCUT Ctrl + Shift + A =====
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.shiftKey && e.key === 'A') {
            e.preventDefault();
            bukaModalAdmin();
        }
        if (e.key === 'Escape') {
            tutupModalAdmin();
        }
    });

    function bukaModalAdmin() {
        document.getElementById('modalAksesAdmin').classList.add('show');
        document.getElementById('inputKodeAkses').value = '';
        document.getElementById('pesanKodeAkses').textContent = '';
        setTimeout(() => document.getElementById('inputKodeAkses').focus(), 100);
    }

    function tutupModalAdmin() {
        document.getElementById('modalAksesAdmin').classList.remove('show');
    }

    function cekKodeAkses() {
        const input    = document.getElementById('inputKodeAkses').value.trim();
        const pesan    = document.getElementById('pesanKodeAkses');
        const btnMasuk = document.querySelector('#modalAksesAdmin .btn-primary');

        if (!input) {
            pesan.className = 'text-danger';
            pesan.textContent = '✗ Kode akses tidak boleh kosong';
            return;
        }

        // Nonaktifkan tombol saat request berjalan
        btnMasuk.disabled = true;
        btnMasuk.textContent = 'Memeriksa...';
        pesan.textContent = '';

        // Kirim ke server — kode tidak pernah disimpan di JavaScript
        fetch('{{ route("admin.aksesRahasia") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ kode: input })
        })
        .then(res => {
            if (res.ok) {
                pesan.className = 'text-success';
                pesan.textContent = '✓ Kode benar, mengalihkan...';
                setTimeout(() => {
                    window.location.href = '{{ route("admin.login") }}';
                }, 600);
            } else if (res.status === 403) {
                pesan.className = 'text-danger';
                pesan.textContent = '✗ Kode akses salah';
                document.getElementById('inputKodeAkses').value = '';
                document.getElementById('inputKodeAkses').focus();
            } else {
                pesan.className = 'text-danger';
                pesan.textContent = '✗ Terjadi kesalahan, coba lagi';
            }
        })
        .catch(() => {
            pesan.className = 'text-danger';
            pesan.textContent = '✗ Tidak dapat terhubung ke server';
        })
        .finally(() => {
            btnMasuk.disabled = false;
            btnMasuk.textContent = 'Masuk';
        });
    }

    // Submit dengan Enter
    document.getElementById('inputKodeAkses').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') cekKodeAkses();
    });

    // Klik di luar modal untuk menutup
    document.getElementById('modalAksesAdmin').addEventListener('click', function(e) {
        if (e.target === this) tutupModalAdmin();
    });
</script>