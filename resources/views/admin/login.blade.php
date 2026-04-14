<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Pengaduan Sarana SMKN 1 BUNTOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('images/bg1.JPG') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Overlay */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.55);
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            overflow: hidden;
        }

        .login-header {
            background: rgba(13, 110, 253, 0.92);
            padding: 28px 24px 20px;
            text-align: center;
            color: white;
        }

        .login-header img {
            height: 70px;
            width: auto;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .login-header h5 {
            font-weight: 700;
            margin-bottom: 2px;
            font-size: 1.1rem;
        }

        .login-header p {
            opacity: 0.85;
            font-size: 0.8rem;
            margin: 0;
        }

        .login-body {
            padding: 28px;
            background: white;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 14px;
            border: 1.5px solid #e0e0e0;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
        }

        .btn-login {
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
        }

        .back-link a {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .back-link a:hover {
            color: white;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">

        {{-- Header dengan Logo --}}
        <div class="login-header">
            <img src="{{ asset('images/logo_smkn1buntok.png') }}"
                alt="Logo SMKN 1 BUNTOK">
            <h5>Login Admin</h5>
            <p>Sistem Pengaduan Sarana SMKN 1 BUNTOK</p>
        </div>

        {{-- Body --}}
        <div class="login-body">

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3">
                    ⚠️ {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.cekLogin') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        required autocomplete="username">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required autocomplete="current-password">
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login">
                    🔐 Masuk
                </button>

            </form>
        </div>
    </div>

    {{-- Link kembali --}}
    <div class="back-link mt-3">
        <a href="{{ route('home') }}">← Kembali ke Halaman Utama</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>