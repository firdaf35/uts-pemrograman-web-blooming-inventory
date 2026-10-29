@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('breadcrumb', 'Kategori / Edit')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Edit Kategori</h1>
            <p>Perbarui informasi kategori {{ $category->name }}.</p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-light">← Kembali</a>
    </div>

    <section class="panel form-panel">
        <h2>Informasi Kategori</h2>

        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Kategori <span class="required">*</span></label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $category->name) }}"
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
                    placeholder="Deskripsi kategori (opsional)"
                >{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    <style>
        .form-panel { max-width: 760px; }
        .form-panel h2 { margin-bottom: 25px; }
        .required { color: #b65e58; }
        .field-error { color: #b65e58; font-size: 12px; margin-top: 7px; }
        textarea.form-control { resize: vertical; }
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 28px; }
    </style>
@endsection