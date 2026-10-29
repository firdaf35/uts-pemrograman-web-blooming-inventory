@extends('layouts.app')

@section('title', 'Detail Produk')
@section('breadcrumb', 'Produk / Detail')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Detail Produk 🌷</h1>
            <p>Informasi lengkap produk dan status persediaannya.</p>
        </div>
        <div class="heading-actions">
            <a href="{{ route('products.index') }}" class="btn btn-light">← Kembali</a>
            <a href="{{ route('products.edit', $product) }}" class="btn">Edit Produk</a>
        </div>
    </div>

    <div class="product-detail-grid">
        <section class="panel">
            <div class="product-flower">✿</div>
            <div class="detail-label">Nama Produk</div>
            <h2 class="product-name">{{ $product->name }}</h2>

            <div class="detail-label">SKU</div>
            <p>{{ $product->sku }}</p>

            <div class="detail-label">Kategori</div>
            <p>{{ $product->category?->name ?? '-' }}</p>

            <div class="detail-label">Deskripsi</div>
            <p class="description">{{ $product->description ?: 'Belum ada deskripsi.' }}</p>
        </section>

        <section class="panel">
            <h2>Informasi Persediaan</h2>

            <div class="detail-label">Stok Saat Ini</div>
            <div class="stock-number">{{ $product->stock }} <small>{{ $product->unit }}</small></div>

            <div class="detail-label">Batas Minimum</div>
            <p>{{ $product->minimum_stock }} {{ $product->unit }}</p>

            <div class="detail-label">Harga Beli</div>
            <p>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>

            <div class="detail-label">Harga Jual</div>
            <p>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>

            <div class="detail-label">Status</div>
            @if ($product->stock == 0)
                <span class="stock-label empty">Stok habis</span>
            @elseif ($product->stock <= $product->minimum_stock)
                <span class="stock-label low">Stok menipis</span>
            @else
                <span class="stock-label normal">Stok tersedia</span>
            @endif

            <div class="detail-label">Terakhir diperbarui</div>
            <p>{{ $product->updated_at?->format('d F Y, H:i') ?? '-' }}</p>
        </section>
    </div>

    <style>
        .heading-actions { display: flex; flex-wrap: wrap; gap: 9px; }
        .product-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .product-flower { font-size: 36px; color: var(--sage); }
        .product-name { font-family: 'Playfair Display', serif; font-size: 27px; font-weight: 500; }
        .detail-label { margin-top: 22px; color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .description { line-height: 1.8; font-size: 13px; }
        .stock-number { margin-top: 8px; font-size: 34px; font-weight: 700; }
        .stock-number small { font-size: 13px; color: var(--muted); }
        .stock-label { display: inline-block; padding: 6px 9px; border-radius: 6px; font-size: 10px; font-weight: 700; }
        .stock-label.empty, .stock-label.low { background: #faeae7; color: #a34d47; }
        .stock-label.normal { background: #eaf1e5; color: #526c48; }
        @media (max-width: 700px) { .product-detail-grid { grid-template-columns: 1fr; } }
    </style>
@endsection