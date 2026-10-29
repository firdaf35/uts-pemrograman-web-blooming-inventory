@extends('layouts.app')

@section('title', 'Edit Produk')
@section('breadcrumb', 'Produk / Edit')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Edit Produk</h1>
            <p>Perbarui informasi {{ $product->name }}.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-light">← Kembali</a>
    </div>

    <section class="panel product-form-panel">
        <h2>Informasi Produk</h2>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            @include('products.form')

            <div class="form-actions">
                <a href="{{ route('products.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    <style>
        .product-form-panel { max-width: 850px; }
        .product-form-panel h2 { margin-bottom: 25px; }
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
    </style>
@endsection