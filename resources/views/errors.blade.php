<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @if (($status ?? 404) === 403)
            Akses Terbatas | Blooming
        @else
            Halaman Tidak Tersedia | Blooming
        @endif
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            background: #fbf6f2;
            color: #512b3a;
            font-family: 'DM Sans', sans-serif;
        }

        .decoration {
            position: fixed;
            color: #ead8dc;
            opacity: .65;
            font-size: 140px;
            pointer-events: none;
            user-select: none;
        }

        .left {
            left: -30px;
            bottom: -25px;
        }

        .right {
            right: -20px;
            top: -20px;
        }

        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 660px;
            padding: 45px 32px;
            text-align: center;
            background: rgba(255, 255, 255, .92);
            border: 1px solid #eadde0;
            border-radius: 28px;
            box-shadow: 0 20px 65px rgba(81, 43, 58, .08);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 34px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: #722f49;
            color: white;
            font: 26px 'Playfair Display', serif;
        }

        .brand-text {
            text-align: left;
        }

        .brand-text h2 {
            font: 25px 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        .brand-text p {
            margin-top: 4px;
            color: #9a7b85;
            font-size: 9px;
            letter-spacing: 2px;
        }

        .flower {
            width: 108px;
            height: 108px;
            display: grid;
            place-items: center;
            margin: 0 auto 25px;
            border: 1px solid #e8cfd5;
            border-radius: 50%;
            background: #f4e5e7;
            font-size: 49px;
        }

        .eyebrow {
            margin-bottom: 12px;
            color: #a66b80;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        h1 {
            margin-bottom: 17px;
            font: 500 clamp(31px, 6vw, 44px)/1.25 'Playfair Display', serif;
        }

        h1 span {
            color: #a45e78;
            font-style: italic;
        }

        .description {
            max-width: 440px;
            margin: 0 auto;
            color: #8b747c;
            font-size: 14px;
            line-height: 1.9;
        }

        .divider {
            width: 52px;
            height: 2px;
            margin: 25px auto;
            background: #d8aab8;
        }

        .notice {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 14px;
            border: 1px solid #efdee3;
            border-radius: 10px;
            background: #f8edf0;
            color: #86566a;
            font-size: 12px;
        }

        .actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .button {
            min-height: 46px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 0 22px;
            border: 1px solid #e5d1d8;
            border-radius: 12px;
            font: 600 13px 'DM Sans', sans-serif;
            text-decoration: none;
            transition: .2s ease;
        }

        .primary {
            color: white;
            background: #722f49;
            border-color: #722f49;
        }

        .primary:hover {
            background: #572138;
            transform: translateY(-2px);
        }

        .secondary {
            color: #722f49;
            background: white;
        }

        .secondary:hover {
            background: #f8edf0;
            transform: translateY(-2px);
        }

        .footer {
            margin-top: 38px;
            padding-top: 20px;
            border-top: 1px solid #eee3e5;
            color: #ad969e;
            font-size: 10px;
            letter-spacing: 1.2px;
        }

        @media (max-width: 480px) {
            .card {
                padding: 35px 21px;
            }

            .actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }

            .decoration {
                font-size: 85px;
            }
        }
    </style>
</head>

<body>
    <div class="decoration left">✿</div>
    <div class="decoration right">❀</div>

    <main class="card">
        <div class="brand">
            <div class="brand-icon">B</div>

            <div class="brand-text">
                <h2>Blooming</h2>
                <p>FLORIST INVENTORY</p>
            </div>
        </div>

        <div class="flower">
            @if (($status ?? 404) === 403)
                🌷
            @else
                🌸
            @endif
        </div>

        @if (($status ?? 404) === 403)

            <p class="eyebrow">Access Restricted</p>

            <h1>
                Halaman ini<br>
                <span>khusus untuk akses tertentu.</span>
            </h1>

            <p class="description">
                Maaf, akun kamu belum memiliki izin untuk membuka
                halaman ini. Beberapa fitur Blooming hanya tersedia
                untuk pengguna dengan hak akses tertentu.
            </p>

            <div class="notice">
                🌷 Akses terbatas · Website tetap berjalan
            </div>

        @else

            <p class="eyebrow">A Little Detour</p>

            <h1>
                Oops, halaman ini<br>
                <span>belum tersedia.</span>
            </h1>

            <p class="description">
                Sepertinya halaman yang kamu cari tidak tersedia
                atau alamatnya sudah berubah. Jangan khawatir,
                kamu masih bisa melanjutkan aktivitas di Blooming.
            </p>

            <div class="notice">
                🌸 Halaman yang dituju tidak ditemukan
            </div>

        @endif

        <div class="divider"></div>

        <p class="description">
            Yuk, kembali ke dashboard dan lanjutkan aktivitasmu.
        </p>

        <div class="actions">
            <a href="{{ url('/dashboard') }}" class="button primary">
                ← Kembali ke Dashboard
            </a>

            <a href="{{ url()->previous() }}" class="button secondary">
                Halaman Sebelumnya
            </a>
        </div>

        <div class="footer">
            BLOOMING FLORIST INVENTORY · GROW WITH GRACE
        </div>
    </main>
</body>
</html>