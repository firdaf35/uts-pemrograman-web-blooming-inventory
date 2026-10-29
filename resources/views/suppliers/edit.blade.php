@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('breadcrumb', 'Supplier / Edit')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Edit Supplier</h1>
            <p>Perbarui informasi {{ $supplier->name }}.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn btn-light">← Kembali</a>
    </div>

    <section class="panel supplier-form-panel">
        <h2>Informasi Supplier</h2>

        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')

            @include('suppliers.form')

            <div class="form-actions">
                <a href="{{ route('suppliers.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    <style>
        .supplier-form-panel { max-width: 800px; }
        .supplier-form-panel h2 { margin-bottom: 25px; }
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
    </style>
@endsection