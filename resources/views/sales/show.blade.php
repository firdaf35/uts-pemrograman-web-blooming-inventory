@extends('layouts.app')

@section('title', 'Detail Penjualan')
@section('breadcrumb', 'Penjualan / Detail')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Detail Penjualan 🌷</h1>
            <p>{{ $sale->sale_number }}</p>
        </div>

        <div class="heading-actions">
            <a href="{{ route('sales.index') }}" class="btn btn-light">
                ← Kembali
            </a>

            @if (auth()->user()->role === 'admin' && $sale->status === 'completed')
                <form
                    action="{{ route('sales.cancel', $sale) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan penjualan ini? Stok produk akan dikembalikan.')"
                >
                    @csrf
                    <button type="submit" class="btn btn-danger cancel-button">
                        Batalkan Transaksi
                    </button>
                </form>
            @endif

            <button type="button" class="btn print-button" onclick="window.print()">
                Cetak Struk
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Transaksi belum berhasil diproses.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel sale-info">
        <div class="info-item">
            <span class="info-label">Nomor Penjualan</span>
            <strong>{{ $sale->sale_number }}</strong>
        </div>

        <div class="info-item">
            <span class="info-label">Tanggal</span>
            <strong>{{ $sale->sale_date?->format('d F Y') ?? '—' }}</strong>
        </div>

        <div class="info-item">
            <span class="info-label">Petugas</span>
            <strong>{{ $sale->user?->name ?? '—' }}</strong>
        </div>

        <div class="info-item">
            <span class="info-label">Status Transaksi</span>
            <span class="status-label {{ $sale->status === 'completed' ? 'status-done' : 'status-cancelled' }}">
                {{ $sale->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
            </span>
        </div>
    </section>

    <section class="panel detail-panel">
        <div class="section-heading">
            <div>
                <h2>Rincian Produk</h2>
                <p>Daftar produk dalam transaksi penjualan ini.</p>
            </div>
            <span class="flower-icon">✿</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($sale->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $item->product?->name ?? 'Produk tidak tersedia' }}</strong>
                                <div class="small-text">
                                    {{ $item->product?->sku ?? '—' }}
                                </div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>
                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                            </td>
                            <td>
                                <strong>
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <span>🌷</span>
                                <p>Tidak ada rincian produk pada transaksi ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="grand-total">
            <div>
                <span>Total Penjualan</span>
                <small>Jumlah keseluruhan transaksi</small>
            </div>
            <strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong>
        </div>

        @if ($sale->notes)
            <div class="notes">
                <span class="info-label">Catatan Penjualan</span>
                <p>{{ $sale->notes }}</p>
            </div>
        @endif

        <div class="receipt-footer">
            <strong>Blooming Inventory ✿</strong>
            <p>Thank you for choosing Blooming. Made with love.</p>
        </div>
    </section>

    <style>
        /* Header */
        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 24px;
        }

        .heading-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 10px;
        }

        .heading-actions form {
            display: inline-flex;
            margin: 0;
            padding: 0;
        }

        /* Tombol */
        .heading-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 38px;
            padding: 10px 14px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: opacity .2s ease, transform .2s ease;
        }

        .heading-actions .btn:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .heading-actions .cancel-button {
            background: #faeae7;
            color: #a34d47;
            border: 1px solid #edc9c3;
        }

        .heading-actions .print-button {
            background: var(--pink, #f0aeba);
            color: var(--plum, #291725);
            border: 1px solid transparent;
        }

        /* Informasi transaksi */
        .sale-info {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            min-width: 0;
        }

        .info-label {
            display: block;
            color: var(--muted);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-item strong {
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .status-label {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-done {
            background: #eaf1e5;
            color: #526c48;
        }

        .status-cancelled {
            background: #faeae7;
            color: #a34d47;
        }

        /* Rincian produk */
        .detail-panel {
            min-width: 0;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .section-heading h2 {
            margin: 0 0 6px;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .flower-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f0aeba24;
            color: var(--pink, #f0aeba);
            font-size: 20px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .small-text {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
        }

        /* Total */
        .grand-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 22px;
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: rgba(255, 255, 255, .035);
        }

        .grand-total span {
            display: block;
            font-size: 13px;
            font-weight: 600;
        }

        .grand-total small {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .grand-total > strong {
            font-size: clamp(20px, 3vw, 26px);
            overflow-wrap: anywhere;
        }

        .notes {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        .notes p {
            margin: 8px 0 0;
            font-size: 13px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .receipt-footer {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px dashed var(--border);
            text-align: center;
        }

        .receipt-footer strong {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
        }

        .receipt-footer p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 11px;
        }

        /* Responsif */
        @media (max-width: 700px) {
            .page-heading {
                flex-direction: column;
            }

            .heading-actions {
                justify-content: flex-start;
                width: 100%;
            }

            .sale-info {
                gap: 18px;
            }

            .grand-total {
                padding: 16px;
            }
        }

        @media (max-width: 420px) {
            .sale-info {
                grid-template-columns: 1fr;
            }

            .heading-actions .btn {
                padding: 9px 10px;
                font-size: 11px;
            }
        }

        /* Cetak struk */
        @media print {
            body {
                background: white !important;
                color: #222 !important;
            }

            .sidebar,
            .topbar,
            .heading-actions,
            .btn {
                display: none !important;
            }

            .main {
                margin: 0 !important;
            }

            .content {
                padding: 0 !important;
            }

            .panel {
                background: white !important;
                color: #222 !important;
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                backdrop-filter: none !important;
                break-inside: avoid;
            }

            .info-label,
            .small-text,
            .section-heading p,
            .grand-total small,
            .receipt-footer p {
                color: #666 !important;
            }

            .sale-info strong,
            .section-heading h2,
            .grand-total strong,
            .receipt-footer strong {
                color: #222 !important;
            }

            table {
                color: #222 !important;
            }

            th, td {
                color: #222 !important;
                border-color: #ddd !important;
            }
        }
    </style>
@endsection