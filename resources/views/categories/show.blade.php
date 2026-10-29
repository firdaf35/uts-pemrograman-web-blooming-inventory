@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('breadcrumb', 'Kategori / Detail')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Detail Kategori 🌸</h1>
            <p>Informasi kategori dan produk yang terhubung dengannya.</p>
        </div>

        <div class="heading-actions">
            <a href="{{ route('categories.index') }}" class="btn btn-light">← Kembali</a>
            <a href="{{ route('categories.edit', $category) }}" class="btn">Edit Kategori</a>
        </div>
    </div>

    <div class="detail-grid">
        <section class="panel">
            <div class="detail-flower">❀</div>
            <div class="detail-label">Nama Kategori</div>
            <h2 class="detail-name">{{ $category->name }}</h2>

            <div class="detail-label">Deskripsi</div>
            <p class="description">{{ $category->description ?: 'Belum ada deskripsi untuk kategori ini.' }}</p>

            <div class="detail-label">Jumlah Produk</div>
            <div class="product-count">{{ $category->products->count() }} produk</div>

            <div class="detail-label">Dibuat pada</div>
            <p class="muted">{{ $category->created_at?->format('d F Y, H:i') ?? '-' }}</p>
        </section>

        <section class="panel">
            <h2>Produk dalam Kategori</h2>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($category->products as $product)
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ $product->stock }} {{ $product->unit }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <span>🌷</span>
                                    <p>Belum ada produk dalam kategori ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <style>
        .heading-actions { display: flex; flex-wrap: wrap; gap: 9px; }
        .detail-grid { display: grid; grid-template-columns: minmax(250px, 0.8fr) minmax(0, 1.5fr); gap: 20px; }
        .detail-flower { font-size: 36px; margin-bottom: 20px; color: var(--sage); }
        .detail-label { margin-top: 22px; color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .detail-name { margin: 9px 0; font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 500; }
        .description { font-size: 13px; line-height: 1.8; overflow-wrap: anywhere; }
        .product-count { margin-top: 8px; font-size: 22px; font-weight: 700; }
        @media (max-width: 800px) { .detail-grid { grid-template-columns: 1fr; } }
    </style>
@endsection