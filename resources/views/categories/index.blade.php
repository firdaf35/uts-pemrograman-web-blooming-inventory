@extends('layouts.app')

@section('title', 'Kategori')
@section('breadcrumb', 'Kategori')

@section('content')
    <div class="page-heading category-heading">
        <div>
            <h1>Kategori Bunga 🌷</h1>
            <p>Kelola dan kelompokkan produk Blooming agar persediaan lebih teratur.</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn add-category-btn">
            + Tambah Kategori
        </a>
    </div>

    <section class="panel category-panel">

        {{-- Pencarian kategori --}}
        <form method="GET"
              action="{{ route('categories.index') }}"
              class="search-form">

            <input
                type="search"
                name="search"
                class="form-control"
                value="{{ $search ?? '' }}"
                placeholder="Cari nama atau deskripsi kategori..."
                aria-label="Cari kategori"
            >

            <button class="btn search-btn" type="submit">
                Cari
            </button>

            @if ($search)
                <a href="{{ route('categories.index') }}"
                   class="btn btn-light">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tabel kategori --}}
        <div class="table-wrap category-table-wrap">
            <table class="category-table">
                <thead>
                    <tr>
                        <th class="number-column">No.</th>
                        <th class="name-column">Nama Kategori</th>
                        <th class="description-column">Deskripsi</th>
                        <th class="product-column">Jumlah Produk</th>
                        <th class="action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>

                            <td class="description-cell">
                                {{ $category->description ?: '—' }}
                            </td>

                            <td>
                                {{ $category->products_count }} produk
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        class="btn btn-light"
                                        href="{{ route('categories.show', $category) }}"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        class="btn"
                                        href="{{ route('categories.edit', $category) }}"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('categories.destroy', $category) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                            <td colspan="5" class="empty-state">
                                <div class="empty-content">
                                    <span class="empty-icon">🌼</span>

                                    <p>
                                        {{ $search
                                            ? 'Kategori yang kamu cari tidak ditemukan.'
                                            : 'Belum ada kategori. Tambahkan kategori pertamamu.'
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
        @if ($categories->hasPages())
            <div class="pagination category-pagination">
                {{ $categories->links() }}
            </div>
        @endif
    </section>

    <style>
        /* Heading */
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

        .add-category-btn {
            flex-shrink: 0;
            white-space: nowrap;
        }

        /* Card utama */
        .category-panel {
            width: 100%;
            box-sizing: border-box;
            padding: 24px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        /* Pencarian */
        .search-form {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 24px;
        }

        .search-form .form-control {
            width: 100%;
            max-width: 430px;
            min-width: 0;
            min-height: 42px;
            box-sizing: border-box;
            padding: 10px 14px;
            font-size: 13px;
        }

        .search-form .btn {
            min-height: 42px;
            padding: 10px 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            cursor: pointer;
            text-decoration: none;
            box-sizing: border-box;
        }

        /* Tabel */
        .category-table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
        }

        .category-table {
            width: 100%;
            min-width: 720px;
            border-collapse: collapse;
            table-layout: auto;
        }

        .category-table th,
        .category-table td {
            padding: 16px 14px;
            text-align: left;
            vertical-align: middle;
            line-height: 1.6;
        }

        .category-table th {
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .category-table td {
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .category-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .category-table tbody tr:last-child {
            border-bottom: none;
        }

        .category-table .number-column {
            width: 55px;
        }

        .category-table .name-column {
            min-width: 150px;
        }

        .category-table .description-column {
            min-width: 180px;
        }

        .category-table .product-column {
            min-width: 125px;
        }

        .category-table .action-column {
            min-width: 200px;
        }

        .description-cell {
            max-width: 280px;
        }

        /* Tombol aksi */
        .actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 7px 12px;
            font-size: 11px;
            white-space: nowrap;
            text-decoration: none;
            box-sizing: border-box;
            cursor: pointer;
        }

        .actions form {
            margin: 0;
        }

        /* Tampilan ketika data kosong */
        .category-table .empty-state {
            padding: 32px 16px;
            text-align: center;
        }

        .empty-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .empty-icon {
            font-size: 26px;
            line-height: 1.3;
        }

        .empty-content p {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
        }

        /* Pagination */
        .category-pagination {
            margin-top: 22px;
        }

        /* Laptop kecil dan tablet */
        @media (max-width: 768px) {
            .category-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .category-panel {
                padding: 18px;
            }

            .search-form .form-control {
                max-width: none;
            }
        }

        /* HP */
        @media (max-width: 480px) {
            .category-panel {
                padding: 14px;
            }

            .search-form {
                flex-wrap: wrap;
            }

            .search-form .form-control {
                flex-basis: 100%;
            }

            .search-form .btn {
                flex: 0 0 auto;
            }
        }
    </style>
@endsection