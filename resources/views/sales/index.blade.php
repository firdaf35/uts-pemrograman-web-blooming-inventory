@extends('layouts.app')

@section('title', 'Penjualan')
@section('breadcrumb', 'Penjualan')

@section('content')
    <div class="page-heading sales-list-heading">
        <div>
            <h1>Penjualan Blooming ✿</h1>
            <p>Kelola transaksi penjualan dan pantau riwayat produk yang terjual.</p>
        </div>

        <a href="{{ route('sales.create') }}" class="btn add-sale-btn">
            + Penjualan Baru
        </a>
    </div>

    <section class="panel sales-list-panel">

        <form method="GET" action="{{ route('sales.index') }}" class="sales-filter-form">
            <input
                type="search"
                name="search"
                class="form-control"
                value="{{ $search ?? '' }}"
                placeholder="Cari nomor transaksi atau nama petugas..."
                aria-label="Cari transaksi penjualan"
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

            <div class="sales-filter-actions">
                <button type="submit" class="btn">Filter</button>
                <a href="{{ route('sales.index') }}" class="btn btn-light">Reset</a>
            </div>
        </form>

        <div class="table-wrap sales-table-wrap">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>No. Penjualan</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th>Jumlah Jenis Produk</th>
                        <th>Total Penjualan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="sale-number">
                                <strong>{{ $sale->sale_number }}</strong>
                            </td>

                            <td>{{ $sale->sale_date?->format('d/m/Y') ?? '—' }}</td>

                            <td>{{ $sale->user?->name ?? '—' }}</td>

                            <td>{{ $sale->items_count }} jenis</td>

                            <td class="sale-amount">
                                Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status-label {{ $sale->status === 'completed' ? 'status-done' : 'status-cancelled' }}">
                                    {{ $sale->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('sales.show', $sale) }}"
                                    class="btn btn-light detail-btn"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="sales-empty-content">
                                    <span>🌷</span>
                                    <p>
                                        {{ ($search ?? '') || ($status ?? '')
                                            ? 'Tidak ada transaksi yang cocok dengan filter.'
                                            : 'Belum ada transaksi penjualan.'
                                        }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sales->hasPages())
            <div class="pagination sales-pagination">
                {{ $sales->links() }}
            </div>
        @endif
    </section>

    <style>
        .sales-list-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .sales-list-heading h1 {
            margin-bottom: 8px;
        }

        .sales-list-heading p {
            margin: 0;
            line-height: 1.7;
        }

        .add-sale-btn {
            flex-shrink: 0;
            white-space: nowrap;
        }

        .sales-list-panel {
            width: 100%;
            box-sizing: border-box;
            padding: 24px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        .sales-filter-form {
            display: grid;
            grid-template-columns: minmax(200px, 2fr) minmax(150px, 1fr) auto;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 24px;
        }

        .sales-filter-form .form-control {
            width: 100%;
            min-width: 0;
            max-width: 100%;
            min-height: 42px;
            padding: 10px 13px;
            box-sizing: border-box;
            font-size: 13px;
        }

        .sales-filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sales-filter-actions .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 42px;
            padding: 10px 15px;
            box-sizing: border-box;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
        }

        .sales-table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
        }

        .sales-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        .sales-table th,
        .sales-table td {
            padding: 15px 13px;
            text-align: left;
            vertical-align: middle;
            line-height: 1.6;
        }

        .sales-table th {
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .sales-table td {
            font-size: 12px;
        }

        .sales-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sales-table tbody tr:last-child {
            border-bottom: none;
        }

        .sale-number {
            min-width: 150px;
            overflow-wrap: anywhere;
        }

        .sale-amount {
            min-width: 145px;
            white-space: nowrap;
        }

        /* Warna status tetap seperti desain sebelumnya */
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
            justify-content: center;
            align-items: center;
            min-height: 34px;
            padding: 7px 13px;
            box-sizing: border-box;
            white-space: nowrap;
            text-decoration: none;
        }

        .sales-table .empty-state {
            padding: 32px 16px;
            text-align: center;
        }

        .sales-empty-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .sales-empty-content span {
            font-size: 26px;
        }

        .sales-empty-content p {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
        }

        .sales-pagination {
            margin-top: 22px;
        }

        @media (max-width: 900px) {
            .sales-filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .sales-filter-actions {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .sales-list-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .sales-list-panel {
                padding: 18px;
            }
        }

        @media (max-width: 480px) {
            .sales-list-panel {
                padding: 14px;
            }

            .sales-filter-form {
                grid-template-columns: minmax(0, 1fr);
            }

            .sales-filter-actions {
                grid-column: auto;
            }
        }
    </style>
@endsection