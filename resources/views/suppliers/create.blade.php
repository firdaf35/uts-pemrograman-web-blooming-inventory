@extends('layouts.app')

@section('title', 'Tambah Supplier')
@section('breadcrumb', 'Supplier / Tambah')

@section('content')
    <div class="page-heading supplier-heading">
        <div>
            <h1>Tambah Supplier 🌿</h1>
            <p>Masukkan informasi pemasok untuk kebutuhan inventory Blooming.</p>
        </div>

        <a href="{{ route('suppliers.index') }}" class="btn btn-light">
            ← Kembali
        </a>
    </div>

    <section class="panel supplier-form-panel">
        <div class="supplier-form-heading">
            <h2>Informasi Supplier</h2>
            <p>Lengkapi informasi pemasok dengan benar.</p>
        </div>

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            @include('suppliers.form')

            <div class="form-actions supplier-form-actions">
                <a href="{{ route('suppliers.index') }}" class="btn btn-light">
                    Batal
                </a>

                <button type="submit" class="btn">
                    Simpan Supplier
                </button>
            </div>
        </form>
    </section>

    <style>
        .supplier-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .supplier-heading h1 {
            margin-bottom: 8px;
        }

        .supplier-heading p {
            margin: 0;
            line-height: 1.7;
        }

        .supplier-form-panel {
            width: 100%;
            max-width: 950px;
            box-sizing: border-box;
            padding: 28px 32px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        .supplier-form-heading {
            margin-bottom: 26px;
        }

        .supplier-form-heading h2 {
            margin: 0 0 8px;
        }

        .supplier-form-heading p {
            margin: 0;
            font-size: 13px;
            line-height: 1.6;
            opacity: 0.8;
        }

        .supplier-form-panel .form-group {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            width: 100%;
            min-width: 0;
            margin-bottom: 22px;
        }

        .supplier-form-panel .form-group label {
            display: block;
            margin: 0;
            line-height: 1.5;
        }

        .supplier-form-panel .form-control {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            min-height: 43px;
            padding: 10px 13px;
            box-sizing: border-box;
            font: inherit;
            font-size: 13px;
        }

        .supplier-form-panel textarea.form-control {
            min-height: 110px;
            line-height: 1.6;
            resize: vertical;
        }

        .supplier-form-panel .form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .supplier-form-panel .form-row > * {
            min-width: 0;
        }

        .supplier-form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .supplier-form-actions .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 42px;
            padding: 10px 18px;
            box-sizing: border-box;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .supplier-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .supplier-form-panel {
                padding: 22px 18px;
            }

            .supplier-form-panel .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
@endsection