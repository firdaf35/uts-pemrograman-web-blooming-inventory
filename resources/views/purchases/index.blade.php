@extends('layouts.app')

@section('title', 'Pembelian')
@section('breadcrumb', 'Pembelian')

@section('content')
    <div class="page-heading purchase-list-heading">
        <div>
            <h1>Pembelian Stok 🌿</h1>
            <p>Catat barang masuk dan pantau riwayat pembelian dari supplier.</p>
        </div>

        <a href="{{ route('purchases.create') }}" class="btn add-purchase-btn">
            + Pembelian Baru
        </a>
    </div>

    <section class="panel purchase-list-panel">

        {{-- Pencarian dan filter --}}
        <form
            method="GET"
            action="{{ route('purchases.index') }}"
            class="purchase-filter-form"
        >
            <input
                type="search"
                name="search"
                class="form-control"
                value="{{ $search ?? '' }}"
                placeholder="Cari nomor transaksi atau supplier..."
                aria-label="Cari nomor transaksi atau supplier"
            >

            <select name="status" class="form-control" aria-label="Filter status">
                <option value="">Semua status</option>
                <option value="completed" @selected($status === 'completed')>
                    Selesai
                </option>
                <option value="cancelled" @selected($status === 'cancelled')>
                    Dibatalkan
                </option>
            </select>

            <div class="purchase-filter-actions">
                <button class="btn" type="submit">Filter</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-light">
                    Reset
                </a>
            </div>
        </form>

        {{-- Tabel riwayat pembelian --}}
        <div class="table-wrap purchase-table-wrap">
            <table class="purchase-table">
                <thead>
                    <tr>
                        <th>No. Pembelian</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Petugas</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td class="purchase-number">
                                <strong>{{ $purchase->purchase_number }}</strong>
                            </td>

                            <td>
                                {{ $purchase->purchase_date?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td>{{ $purchase->supplier?->name ?? '—' }}</td>

                            <td>{{ $purchase->user?->name ?? '—' }}</td>

                            <td class="purchase-amount">
                                Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status-label {{ $purchase->status === 'completed' ? 'status-done' : 'status-cancelled' }}">
                                    {{ $purchase->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('purchases.show', $purchase) }}"
                                    class="btn btn-light detail-btn"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="purchase-empty-content">
                                    <span>🌷</span>
                                    <p>
                                        {{ ($search ?? '') || ($status ?? '')
                                            ? 'Tidak ada transaksi yang cocok dengan filter.'
                                            : 'Belum ada transaksi pembelian.'
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
        @if ($purchases->hasPages())
            <div class="pagination purchase-pagination">
                {{ $purchases->links() }}
            </div>
        @endif
    </section>

    <style>
        /* Heading */
        .purchase-list-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .purchase-list-heading h1 {
            margin-bottom: 8px;
        }

        .purchase-list-heading p {
            margin: 0;
            line-height: 1.7;
        }

        .add-purchase-btn {
            flex-shrink: 0;
            white-space: nowrap;
        }

        /* Panel utama */
        .purchase-list-panel {
            width: 100%;
            box-sizing: border-box;
            padding: 24px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        /* Filter */
        .purchase-filter-form {
            display: grid;
            grid-template-columns: minmax(200px, 2fr) minmax(150px, 1fr) auto;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 24px;
        }

        .purchase-filter-form .form-control {
            width: 100%;
            min-width: 0;
            max-width: 100%;
            min-height: 42px;
            padding: 10px 13px;
            box-sizing: border-box;
            font-size: 13px;
        }

        .purchase-filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .purchase-filter-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 15px;
            box-sizing: border-box;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
        }

        /* Tabel */
        .purchase-table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
        }

        .purchase-table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        .purchase-table th,
        .purchase-table td {
            padding: 15px 13px;
            text-align: left;
            vertical-align: middle;
            line-height: 1.6;
        }

        .purchase-table th {
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .purchase-table td {
            font-size: 12px;
        }

        .purchase-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .purchase-table tbody tr:last-child {
            border-bottom: none;
        }

        .purchase-number {
            min-width: 150px;
            overflow-wrap: anywhere;
        }

        .purchase-amount {
            min-width: 135px;
            white-space: nowrap;
        }

        /* Status: warna asli dipertahankan */
        .status-label {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-done {
            background: #eaf1e5;
            color: #526c48;
        }

        .status-cancelled {
            background: #faeae7;
            color: #a34d47;
        }

        .detail-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 7px 13px;
            box-sizing: border-box;
            white-space: nowrap;
            text-decoration: none;
        }

        /* Data kosong */
        .purchase-table .empty-state {
            padding: 32px 16px;
            text-align: center;
        }

        .purchase-empty-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .purchase-empty-content span {
            font-size: 26px;
        }

        .purchase-empty-content p {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
        }

        .purchase-pagination {
            margin-top: 22px;
        }

        /* Tablet */
        @media (max-width: 900px) {
            .purchase-filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .purchase-filter-actions {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .purchase-list-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .purchase-list-panel {
                padding: 18px;
            }
        }

        /* HP */
        @media (max-width: 480px) {
            .purchase-list-panel {
                padding: 14px;
            }

            .purchase-filter-form {
                grid-template-columns: minmax(0, 1fr);
            }

            .purchase-filter-actions {
                grid-column: auto;
            }
        }
    </style>
@endsection