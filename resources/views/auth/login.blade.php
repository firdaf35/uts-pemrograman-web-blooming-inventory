<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Blooming Florist Inventory</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --plum: #291725;
            --wine: #572b3b;
            --pink: #f0aeba;
            --cream: #fff8f2;
            --muted: #e0cedb;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            background:
                linear-gradient(
                    135deg,
                    rgba(36, 20, 39, .78),
                    rgba(83, 39, 67, .66),
                    rgba(41, 23, 37, .82)
                ),
                url("{{ asset('images/blooming-bg.jpg') }}");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            color: var(--cream);
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            padding: 38px;
            background: linear-gradient(
                145deg,
                rgba(94, 44, 68, .88),
                rgba(41, 23, 37, .94)
            );
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 20px;
            box-shadow: 0 24px 70px rgba(15, 7, 18, .35);
            backdrop-filter: blur(16px);
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-mark {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 1px solid rgba(240, 174, 186, .6);
            border-radius: 50%;
            color: var(--pink);
            font-family: 'Playfair Display', serif;
            font-size: 34px;
        }

        .brand-name {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 35px;
            font-weight: 500;
            letter-spacing: -1px;
        }

        .brand-subtitle {
            margin: 7px 0 0;
            color: var(--pink);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .welcome-title {
            margin: 0 0 8px;
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 500;
            text-align: center;
        }

        .welcome-text {
            margin: 0 0 28px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
            text-align: center;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--cream);
            font-size: 12px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            min-height: 45px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, .09);
            color: var(--cream);
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 9px;
            outline: none;
            font-family: inherit;
            font-size: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control::placeholder {
            color: #d2bcca;
        }

        .form-control:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(240, 174, 186, .13);
        }

        .field-error {
            margin-top: 7px;
            color: #ffc3c8;
            font-size: 11px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 3px 0 23px;
            color: var(--muted);
            font-size: 12px;
        }

        .remember-row input {
            width: 15px;
            height: 15px;
            accent-color: var(--pink);
            cursor: pointer;
        }

        .login-button {
            width: 100%;
            min-height: 46px;
            padding: 12px;
            background: var(--pink);
            color: #351c2a;
            border: none;
            border-radius: 9px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: transform .2s, background .2s;
        }

        .login-button:hover {
            background: #f7c5ce;
            transform: translateY(-1px);
        }

        .forgot-link {
            display: block;
            margin-top: 19px;
            color: var(--muted);
            font-size: 11px;
            text-align: center;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: var(--pink);
            text-decoration: underline;
        }

        .login-footer {
            margin: 27px 0 0;
            padding-top: 19px;
            border-top: 1px solid rgba(255, 255, 255, .14);
            color: var(--muted);
            font-size: 10px;
            letter-spacing: 1px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 23px;
                border-radius: 16px;
            }

            .brand-name {
                font-size: 31px;
            }

            .welcome-title {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>
    <main class="login-page">
        <section class="login-card">

            <div class="brand">
                <div class="brand-mark">b.</div>
                <h1 class="brand-name">blooming.</h1>
                <p class="brand-subtitle">FLORIST INVENTORY</p>
            </div>

            <h2 class="welcome-title">Selamat Datang ♡</h2>
            <p class="welcome-text">
                Masuk ke akunmu untuk mengelola inventory Blooming.
            </p>

            @if (session('status'))
                <div class="field-error" style="margin-bottom: 18px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        class="form-control"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required
                        autofocus
                        autocomplete="username"
                    >

                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        class="form-control"
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                    >

                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <label class="remember-row" for="remember_me">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                    >
                    <span>Ingat saya</span>
                </label>

                <button class="login-button" type="submit">
                    MASUK KE BLOOMING →
                </button>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </form>

            <p class="login-footer">
                BLOOMING FLORIST INVENTORY © {{ date('Y') }}
            </p>

        </section>
    </main>
</body>
</html>