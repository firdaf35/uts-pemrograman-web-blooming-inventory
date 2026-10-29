@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('breadcrumb', 'Produk / Tambah')

@section('content')
    <div class="page-heading product-heading">
        <div>
            <h1>Tambah Produk 🌷</h1>
            <p>Tambahkan produk bunga baru ke inventory Blooming.</p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-light">
            ← Kembali
        </a>
    </div>

    <section class="panel product-form-panel">
        <div class="product-form-heading">
            <h2>Informasi Produk</h2>
            <p>Lengkapi data produk dan persediaan bunga.</p>
        </div>

        @if ($categories->isEmpty())
            <div class="alert alert-error">
                Belum ada kategori. Tambahkan kategori terlebih dahulu
                sebelum membuat produk.
                <a href="{{ route('categories.create') }}">
                    <strong>Buat kategori →</strong>
                </a>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            @include('products.form')

            <div class="form-actions product-form-actions">
                <a href="{{ route('products.index') }}" class="btn btn-light">
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn"
                    @disabled($categories->isEmpty())
                >
                    Simpan Produk
                </button>
            </div>
        </form>
    </section>

    <style>
        /* Heading halaman */
        .product-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .product-heading h1 {
            margin-bottom: 8px;
        }

        .product-heading p {
            margin: 0;
            line-height: 1.7;
        }

        /* Panel form */
        .product-form-panel {
            width: 100%;
            max-width: 950px;
            box-sizing: border-box;
            padding: 28px 32px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        .product-form-heading {
            margin-bottom: 26px;
        }

        .product-form-heading h2 {
            margin: 0 0 8px;
        }

        .product-form-heading p {
            margin: 0;
            font-size: 13px;
            line-height: 1.6;
            opacity: 0.8;
        }

        /* Form produk: label dan input */
        .product-form-panel form .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
            min-width: 0;
        }

        .product-form-panel form .form-group label {
            display: block;
            margin: 0;
            line-height: 1.5;
        }

        .product-form-panel form .form-control {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .product-form-panel form input.form-control,
        .product-form-panel form select.form-control {
            min-height: 44px;
            padding: 10px 14px;
        }

        .product-form-panel form textarea.form-control {
            min-height: 120px;
            padding: 12px 14px;
            line-height: 1.6;
            resize: vertical;
        }

        /* Jika products.form memiliki layout dua kolom */
        .product-form-panel .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 24px;
        }

        .product-form-panel .form-grid > * {
            min-width: 0;
        }

        /* Tombol */
        .product-form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .product-form-actions .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 42px;
            padding: 10px 18px;
            box-sizing: border-box;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        /* Laptop kecil dan tablet */
        @media (max-width: 768px) {
            .product-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .product-form-panel {
                padding: 22px 18px;
            }

            .product-form-panel .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }

        @media (max-width: 400px) {
            .product-form-actions {
                gap: 8px;
            }

            .product-form-actions .btn {
                padding: 10px 12px;
            }
        }
    </style>
@endsection