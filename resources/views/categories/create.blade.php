@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('breadcrumb', 'Kategori / Tambah')

@section('content')
    <div class="page-heading category-heading">
        <div>
            <h1>Tambah Kategori</h1>
            <p>Buat kategori baru untuk mengelompokkan produk bunga.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-light">
            ← Kembali
        </a>
    </div>

    <section class="panel form-panel">
        <div class="form-panel-heading">
            <h2>Informasi Kategori</h2>
            <p>Lengkapi informasi kategori bunga di bawah ini.</p>
        </div>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">
                    Nama Kategori <span class="required">*</span>
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Mawar, Tulip, Buket"
                    maxlength="255"
                    required
                >

                @error('name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>

                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    rows="5"
                    maxlength="2000"
                    placeholder="Jelaskan kategori ini (opsional)"
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a
                    href="{{ route('categories.index') }}"
                    class="btn btn-light"
                >
                    Batal
                </a>

                <button type="submit" class="btn">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </section>

    <style>
        /* Heading halaman */
        .category-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .category-heading h1 {
            margin-bottom: 8px;
        }

        .category-heading p {
            margin: 0;
            line-height: 1.7;
        }

        /* Panel form: warna mengikuti tema asli */
        .form-panel {
            width: 100%;
            max-width: 900px;
            box-sizing: border-box;
            padding: 28px 32px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        .form-panel-heading {
            margin-bottom: 28px;
        }

        .form-panel-heading h2 {
            margin: 0 0 8px;
        }

        .form-panel-heading p {
            margin: 0;
            line-height: 1.6;
            font-size: 13px;
            opacity: 0.8;
        }

        /* Jarak setiap kolom */
        .form-panel .form-group {
            display: flex;
            flex-direction: column;
            gap: 9px;
            margin-bottom: 22px;
        }

        .form-panel .form-group label {
            display: block;
            margin: 0;
            font-size: 14px;
            font-weight: 500;
        }

        .required {
            color: #b65e58;
        }

        /* Input nama kategori dan deskripsi */
        .form-panel .form-control {
            display: block;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
            padding: 12px 14px;
            border-radius: 8px;
            font: inherit;
            font-size: 14px;
        }

        .form-panel input.form-control {
            min-height: 44px;
        }

        .form-panel textarea.form-control {
            min-height: 130px;
            line-height: 1.6;
            resize: vertical;
        }

        .form-panel .form-control::placeholder {
            opacity: 0.65;
        }

        .field-error {
            color: #b65e58;
            font-size: 12px;
            margin-top: 2px;
        }

        /* Tombol di kanan bawah */
        .form-panel .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .form-panel .form-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 18px;
            box-sizing: border-box;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        /* Tampilan laptop kecil dan HP */
        @media (max-width: 768px) {
            .category-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .form-panel {
                max-width: 100%;
                padding: 22px 18px;
            }

            .form-panel .form-actions {
                gap: 10px;
            }
        }

        @media (max-width: 400px) {
            .form-panel .form-actions {
                justify-content: stretch;
            }

            .form-panel .form-actions .btn {
                flex: 1;
                padding: 10px 12px;
            }
        }
    </style>
@endsection