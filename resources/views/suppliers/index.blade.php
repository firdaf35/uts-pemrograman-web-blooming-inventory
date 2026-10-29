@extends('layouts.app')

@section('title', 'Supplier')
@section('breadcrumb', 'Supplier')

@section('content')
    <div class="page-heading supplier-list-heading">
        <div>
            <h1>Our Suppliers ✿</h1>
            <p>Kelola informasi pemasok bunga dan kebutuhan florist Blooming.</p>
        </div>

        <a href="{{ route('suppliers.create') }}" class="btn add-supplier-btn">
            + Tambah Supplier
        </a>
    </div>

    <section class="panel supplier-list-panel">

        {{-- Pencarian supplier --}}
        <form
            method="GET"
            action="{{ route('suppliers.index') }}"
            class="supplier-search-form"
        >
            <input
                type="search"
                name="search"
                class="form-control"
                value="{{ $search ?? '' }}"
                placeholder="Cari nama, kontak, nomor telepon, atau email..."
                aria-label="Cari supplier"
            >

            <button type="submit" class="btn">Cari</button>

            @if ($search)
                <a href="{{ route('suppliers.index') }}" class="btn btn-light">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tabel supplier --}}
        <div class="table-wrap supplier-table-wrap">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Kontak Person</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Total Pembelian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td>
                                <strong>{{ $supplier->name }}</strong>
                            </td>

                            <td>{{ $supplier->contact_person ?: '—' }}</td>

                            <td>{{ $supplier->phone ?: '—' }}</td>

                            <td class="supplier-email">
                                {{ $supplier->email ?: '—' }}
                            </td>

                            <td class="purchase-count">
                                {{ $supplier->purchases_count }} transaksi
                            </td>

                            <td>
                                <div class="supplier-actions">
                                    <a
                                        href="{{ route('suppliers.show', $supplier) }}"
                                        class="btn btn-light"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('suppliers.edit', $supplier) }}"
                                        class="btn"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('suppliers.destroy', $supplier) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="supplier-empty-content">
                                    <span>🌷</span>

                                    <p>
                                        {{ $search
                                            ? 'Supplier tidak ditemukan.'
                                            : 'Belum ada supplier. Tambahkan supplier pertamamu.'
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
        @if ($suppliers->hasPages())
            <div class="pagination supplier-pagination">
                {{ $suppliers->links() }}
            </div>
        @endif
    </section>

    <style>
        /* Heading */
        .supplier-list-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .supplier-list-heading h1 {
            margin-bottom: 8px;
        }

        .supplier-list-heading p {
            margin: 0;
            line-height: 1.7;
        }

        .add-supplier-btn {
            flex-shrink: 0;
            white-space: nowrap;
        }

        /* Card */
        .supplier-list-panel {
            width: 100%;
            box-sizing: border-box;
            padding: 24px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        /* Pencarian */
        .supplier-search-form {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 24px;
        }

        .supplier-search-form .form-control {
            width: 100%;
            max-width: 500px;
            min-width: 0;
            min-height: 42px;
            padding: 10px 14px;
            box-sizing: border-box;
            font-size: 13px;
        }

        .supplier-search-form .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 16px;
            box-sizing: border-box;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
        }

        /* Tabel */
        .supplier-table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
        }

        .supplier-table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        .supplier-table th,
        .supplier-table td {
            padding: 15px 13px;
            text-align: left;
            vertical-align: middle;
            line-height: 1.6;
        }

        .supplier-table th {
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .supplier-table td {
            font-size: 12px;
        }

        .supplier-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .supplier-table tbody tr:last-child {
            border-bottom: none;
        }

        .supplier-email {
            min-width: 160px;
            overflow-wrap: anywhere;
        }

        .purchase-count {
            min-width: 130px;
            white-space: nowrap;
        }

        /* Tombol aksi */
        .supplier-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .supplier-actions form {
            margin: 0;
        }

        .supplier-actions .btn {
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

        /* Data kosong */
        .supplier-table .empty-state {
            padding: 32px 16px;
            text-align: center;
        }

        .supplier-empty-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .supplier-empty-content span {
            font-size: 26px;
        }

        .supplier-empty-content p {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
        }

        /* Pagination */
        .supplier-pagination {
            margin-top: 22px;
        }

        /* Tablet dan layar kecil */
        @media (max-width: 768px) {
            .supplier-list-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .supplier-list-panel {
                padding: 18px;
            }
        }

        @media (max-width: 480px) {
            .supplier-list-panel {
                padding: 14px;
            }

            .supplier-search-form {
                flex-wrap: wrap;
            }

            .supplier-search-form .form-control {
                max-width: 100%;
                flex-basis: 100%;
            }
        }
    </style>
@endsection