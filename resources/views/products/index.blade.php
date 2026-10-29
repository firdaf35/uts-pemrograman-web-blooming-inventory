@extends('layouts.app')

@section('title', 'Produk')
@section('breadcrumb', 'Produk & Stok')

@section('content')
    <div class="page-heading product-list-heading">
        <div>
            <h1>Produk & Stok 🌿</h1>
            <p>Kelola katalog bunga, harga, SKU, dan persediaan produk.</p>
        </div>

        <a href="{{ route('products.create') }}" class="btn add-product-btn">
            + Tambah Produk
        </a>
    </div>

    <section class="panel product-list-panel">

        {{-- Pencarian dan filter --}}
        <form method="GET"
              action="{{ route('products.index') }}"
              class="filter-form">

            <input
                type="search"
                name="search"
                class="form-control"
                value="{{ $search ?? '' }}"
                placeholder="Cari nama atau SKU..."
                aria-label="Cari nama atau SKU produk"
            >

            <select name="category_id" class="form-control"
                    aria-label="Filter kategori">
                <option value="">Semua kategori</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected((string) $categoryId === (string) $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="stock_status" class="form-control"
                    aria-label="Filter status stok">
                <option value="">Semua stok</option>
                <option value="low" @selected($stockStatus === 'low')>
                    Stok menipis
                </option>
                <option value="available" @selected($stockStatus === 'available')>
                    Stok tersedia
                </option>
                <option value="empty" @selected($stockStatus === 'empty')>
                    Stok habis
                </option>
            </select>

            <div class="filter-actions">
                <button type="submit" class="btn">Filter</button>

                <a href="{{ route('products.index') }}" class="btn btn-light">
                    Reset
                </a>
            </div>
        </form>

        {{-- Tabel produk --}}
        <div class="table-wrap product-table-wrap">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="product-name-cell">
                                <strong>{{ $product->name }}</strong>
                                <div class="small-text">
                                    {{ $product->sku }}
                                </div>
                            </td>

                            <td>{{ $product->category?->name ?? '-' }}</td>

                            <td>
                                Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                            </td>

                            <td class="stock-number">
                                {{ $product->stock }} {{ $product->unit }}
                            </td>

                            <td>
                                @if ($product->stock == 0)
                                    <span class="stock-label empty">Habis</span>
                                @elseif ($product->stock <= $product->minimum_stock)
                                    <span class="stock-label low">Menipis</span>
                                @else
                                    <span class="stock-label normal">Tersedia</span>
                                @endif
                            </td>

                            <td>
                                <div class="product-actions">
                                    <a
                                        class="btn btn-light"
                                        href="{{ route('products.show', $product) }}"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        class="btn"
                                        href="{{ route('products.edit', $product) }}"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-content">
                                    <span>🌷</span>
                                    <p>
                                        {{ $search || $categoryId || $stockStatus
                                            ? 'Tidak ada produk yang cocok dengan filter.'
                                            : 'Belum ada produk. Tambahkan produk pertama Blooming.'
                                        }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="pagination product-pagination">
                {{ $products->links() }}
            </div>
        @endif
    </section>

    <style>
        /* Heading */
        .product-list-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .product-list-heading h1 {
            margin-bottom: 8px;
        }

        .product-list-heading p {
            margin: 0;
            line-height: 1.7;
        }

        .add-product-btn {
            flex-shrink: 0;
            white-space: nowrap;
        }

        /* Panel utama */
        .product-list-panel {
            width: 100%;
            box-sizing: border-box;
            padding: 24px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        /* Filter */
        .filter-form {
            display: grid;
            grid-template-columns: minmax(180px, 2fr)
                                   minmax(130px, 1fr)
                                   minmax(130px, 1fr)
                                   auto;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 24px;
        }

        .filter-form .form-control {
            width: 100%;
            min-width: 0;
            max-width: 100%;
            min-height: 42px;
            box-sizing: border-box;
            padding: 10px 12px;
            font-size: 13px;
        }

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-actions .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 42px;
            padding: 10px 14px;
            box-sizing: border-box;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
        }

        /* Tabel */
        .product-table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
        }

        .product-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        .product-table th,
        .product-table td {
            padding: 15px 13px;
            text-align: left;
            vertical-align: middle;
            line-height: 1.6;
        }

        .product-table th {
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .product-table td {
            font-size: 12px;
        }

        .product-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .product-table tbody tr:last-child {
            border-bottom: none;
        }

        .product-name-cell {
            min-width: 145px;
        }

        .small-text {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
            overflow-wrap: anywhere;
        }

        .stock-number {
            white-space: nowrap;
        }

        /* Status stok: pertahankan warna asli */
        .stock-label {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .stock-label.empty,
        .stock-label.low {
            background: #faeae7;
            color: #a34d47;
        }

        .stock-label.normal {
            background: #eaf1e5;
            color: #526c48;
        }

        /* Aksi */
        .product-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .product-actions form {
            margin: 0;
        }

        .product-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 33px;
            padding: 7px 10px;
            font-size: 11px;
            white-space: nowrap;
            text-decoration: none;
            box-sizing: border-box;
            cursor: pointer;
        }

        /* Produk kosong */
        .product-table .empty-state {
            padding: 32px 16px;
            text-align: center;
        }

        .empty-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .empty-content span {
            font-size: 26px;
        }

        .empty-content p {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
        }

        /* Pagination */
        .product-pagination {
            margin-top: 22px;
        }

        /* Laptop dan tablet */
        @media (max-width: 1100px) {
            .filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .filter-actions {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .product-list-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .product-list-panel {
                padding: 18px;
            }
        }

        /* HP */
        @media (max-width: 480px) {
            .product-list-panel {
                padding: 14px;
            }

            .filter-form {
                grid-template-columns: minmax(0, 1fr);
            }
        }
    </style>
@endsection