@extends('layouts.app')

@section('title', 'Laporan')
@section('breadcrumb', 'Laporan')

@section('content')
<div class="report-page">

    <div class="page-heading report-heading">
        <div>
            <h1>Laporan Blooming ✿</h1>
            <p>Ringkasan performa inventory dan transaksi florist.</p>
        </div>

        <button type="button" class="btn print-btn" onclick="window.print()">
            Cetak Laporan
        </button>
    </div>

    {{-- Filter periode laporan --}}
    <section class="report-panel filter-panel">
        <form action="{{ route('reports.index') }}" method="GET" class="report-filter-form">
            <div class="form-group">
                <label for="start_date">Dari Tanggal</label>
                <input
                    class="form-control"
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ $startDate }}"
                    max="{{ $endDate }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="end_date">Sampai Tanggal</label>
                <input
                    class="form-control"
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ $endDate }}"
                    min="{{ $startDate }}"
                    required
                >
            </div>

            <div class="filter-actions">
                <button class="btn" type="submit">Tampilkan</button>
                <a class="btn reset-btn" href="{{ route('reports.index') }}">Reset</a>
            </div>
        </form>

        <p class="period">
            Periode:
            {{ \Illuminate\Support\Carbon::parse($startDate)->format('d M Y') }}
            —
            {{ \Illuminate\Support\Carbon::parse($endDate)->format('d M Y') }}
        </p>
    </section>

    {{-- Statistik --}}
    <section class="report-stats">
        @foreach ([
            ['Total Produk', $totalProducts, 'Produk terdaftar', '🌷'],
            ['Total Supplier', $totalSuppliers, 'Pemasok terdaftar', '✿'],
            ['Transaksi Pembelian', $totalPurchases, 'Pembelian selesai', '↙'],
            ['Transaksi Penjualan', $totalSales, 'Penjualan selesai', '♡']
        ] as [$label, $value, $description, $icon])
            <article class="report-panel stat-card">
                <div class="stat-top">
                    <span class="stat-icon">{{ $icon }}</span>
                    <span class="stat-caption">{{ $description }}</span>
                </div>

                <p>{{ $label }}</p>
                <h2>{{ number_format($value) }}</h2>
            </article>
        @endforeach
    </section>

    {{-- Nilai transaksi --}}
    <section class="value-grid">
        @foreach ([
            ['Total Pembelian', $purchaseValue, 'Barang masuk', '↙'],
            ['Total Penjualan', $salesValue, 'Barang terjual', '↗']
        ] as [$label, $value, $description, $icon])
            <article class="report-panel value-card">
                <div class="value-heading">
                    <span class="stat-icon">{{ $icon }}</span>

                    <div>
                        <p>{{ $label }}</p>
                        <small>{{ $description }}</small>
                    </div>
                </div>

                <h2>Rp {{ number_format($value, 0, ',', '.') }}</h2>
                <small>Total transaksi selesai dalam periode terpilih.</small>
            </article>
        @endforeach
    </section>

    {{-- Produk terlaris --}}
    <section class="report-panel report-section">
        <div class="section-heading">
            <div>
                <h2>Produk Terlaris 🌷</h2>
                <p>Produk berdasarkan jumlah unit terjual.</p>
            </div>
        </div>

        <div class="table-wrap report-table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Produk</th>
                        <th>SKU</th>
                        <th>Terjual</th>
                        <th>Nilai Penjualan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bestSellingProducts as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ number_format($product->total_quantity) }} unit</td>
                            <td class="money-cell">
                                Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                <span>🌷</span>
                                <p>Belum ada penjualan pada periode ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Stok menipis --}}
    <section class="report-panel report-section">
        <div class="section-heading">
            <div>
                <h2>Perhatian Stok</h2>
                <p>Produk yang mencapai batas minimum stok.</p>
            </div>

            <span class="pill">{{ $lowStockProducts->total() }} produk</span>
        </div>

        <div class="table-wrap report-table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Minimum</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                <small class="subtext">{{ $product->sku }}</small>
                            </td>

                            <td>{{ $product->category?->name ?? '—' }}</td>

                            <td>{{ $product->stock }} {{ $product->unit }}</td>

                            <td>{{ $product->minimum_stock }} {{ $product->unit }}</td>

                            <td>
                                <span class="pill {{ $product->stock == 0 ? 'pill-danger' : 'pill-warning' }}">
                                    {{ $product->stock == 0 ? 'Habis' : 'Menipis' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                <span>🌿</span>
                                <p>Semua stok berada di atas batas minimum.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($lowStockProducts->hasPages())
            <div class="pagination report-pagination">
                {{ $lowStockProducts->links() }}
            </div>
        @endif
    </section>

    {{-- Transaksi terbaru --}}
    <section class="recent-grid">
        @foreach ([
            ['Pembelian Terbaru', $recentPurchases, 'purchase_number', 'supplier', 'purchase_date', 'purchases.show'],
            ['Penjualan Terbaru', $recentSales, 'sale_number', 'user', 'sale_date', 'sales.show']
        ] as [$heading, $transactions, $numberField, $relation, $dateField, $routeName])
            <article class="report-panel recent-panel">
                <div class="section-heading">
                    <div>
                        <h2>{{ $heading }}</h2>
                        <p>Riwayat transaksi terbaru dalam periode laporan.</p>
                    </div>
                </div>

                <div class="transaction-list">
                    @forelse ($transactions as $transaction)
                        <a class="transaction-row" href="{{ route($routeName, $transaction) }}">
                            <span class="stat-icon">
                                {{ $relation === 'supplier' ? '↙' : '♡' }}
                            </span>

                            <span class="transaction-info">
                                <strong>{{ $transaction->$numberField }}</strong>

                                <small>
                                    {{ $transaction->$relation?->name ?? ($relation === 'user' ? 'Petugas' : 'Supplier') }}
                                    ·
                                    {{ $transaction->$dateField?->format('d/m/Y') ?? '—' }}
                                </small>
                            </span>

                            <strong class="transaction-value">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </strong>
                        </a>
                    @empty
                        <div class="empty recent-empty">
                            <span>🌷</span>
                            <p>Belum ada transaksi pada periode ini.</p>
                        </div>
                    @endforelse
                </div>
            </article>
        @endforeach
    </section>

</div>

<style>
    .report-page {
        --report-wine: #572b3b;
        --report-plum: #291725;
        --report-pink: #f0aeba;
        --report-cream: #fff8f2;

        width: 100%;
        min-width: 0;
        color: var(--report-cream);
        box-sizing: border-box;
    }

    .report-page *,
    .report-page *::before,
    .report-page *::after {
        box-sizing: border-box;
    }

    /* Judul halaman */
    .report-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .report-page .page-heading h1,
    .report-page h2 {
        color: var(--report-cream);
        font-family: 'Playfair Display', serif;
        font-weight: 500;
    }

    .report-page .page-heading h1 {
        margin-bottom: 8px;
    }

    .report-page .page-heading p,
    .report-page .section-heading p,
    .report-page small,
    .report-page .period {
        color: #e0cedb;
        font-size: 11px;
        line-height: 1.7;
    }

    .report-page .page-heading p {
        margin: 0;
    }

    .report-page .print-btn {
        flex-shrink: 0;
        white-space: nowrap;
        cursor: pointer;
    }

    /* Panel utama: mempertahankan warna Blooming */
    .report-panel {
        min-width: 0;
        padding: 22px;
        background: linear-gradient(
            135deg,
            rgba(94, 44, 68, .88),
            rgba(43, 25, 43, .91)
        );
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 15px;
        box-shadow: 0 12px 30px #180b1830;
        backdrop-filter: blur(14px);
    }

    /* Filter tanggal */
    .filter-panel {
        margin-bottom: 20px;
    }

    .report-filter-form {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto;
        align-items: end;
        gap: 16px;
        margin-bottom: 15px;
    }

    .report-filter-form .form-group {
        min-width: 0;
        margin: 0;
    }

    .report-page .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #fff0f1;
        font-size: 12px;
    }

    .report-page .form-control {
        width: 100%;
        min-width: 0;
        min-height: 42px;
        padding: 10px 12px;
        background: #ffffff12;
        color: var(--report-cream);
        border: 1px solid #ffffff35;
        border-radius: 8px;
        font: inherit;
        font-size: 12px;
    }

    .report-page input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        filter: invert(1);
    }

    .report-filter-form .filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .report-page .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 10px 15px;
        background: var(--report-pink);
        color: #351c2a;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 12px;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
    }

    .report-page .reset-btn {
        background: #ffffff12;
        color: var(--report-cream);
        border-color: #ffffff30;
    }

    .report-page .period {
        margin: 0;
    }

    /* Kartu statistik */
    .report-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .stat-card {
        display: flex;
        flex-direction: column;
        min-width: 0;
        min-height: 165px;
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .stat-icon {
        display: inline-flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        border-radius: 10px;
        background: #f0aeba24;
        color: var(--report-pink);
        font-size: 17px;
    }

    .stat-caption {
        text-align: right;
    }

    .stat-card p,
    .value-heading p {
        margin: 14px 0 7px;
        color: #ead8e3;
        font-size: 12px;
        line-height: 1.6;
    }

    .stat-card h2 {
        margin: auto 0 0;
        font-size: 28px;
        overflow-wrap: anywhere;
    }

    /* Nilai pembelian dan penjualan */
    .value-grid,
    .recent-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 18px;
    }

    .value-card {
        min-height: 170px;
    }

    .value-heading {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .value-heading p {
        margin: 0 0 4px;
    }

    .value-card h2 {
        margin: 22px 0 9px;
        font-size: 29px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    /* Tabel laporan */
    .report-section {
        margin-bottom: 18px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .section-heading h2 {
        margin: 0 0 6px;
        font-size: 21px;
        line-height: 1.4;
    }

    .section-heading p {
        margin: 0;
    }

    .report-table-wrap {
        width: 100%;
        overflow-x: auto;
        border-radius: 8px;
    }

    .report-page table {
        width: 100%;
        min-width: 520px;
        border-collapse: collapse;
        color: var(--report-cream);
    }

    .report-page th,
    .report-page td {
        padding: 14px 13px;
        text-align: left;
        vertical-align: middle;
        line-height: 1.6;
        border-bottom: 1px solid #ffffff17;
    }

    .report-page th {
        background: #ffffff10;
        color: #ead8e3;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .report-page td {
        color: var(--report-cream);
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .report-page tbody tr:last-child td {
        border-bottom: none;
    }

    .money-cell {
        min-width: 150px;
        white-space: nowrap;
    }

    .subtext {
        display: block;
        margin-top: 4px;
    }

    .pill {
        display: inline-block;
        padding: 6px 9px;
        background: #d6e9ca22;
        color: #d5efc9;
        border-radius: 7px;
        font-size: 10px;
        white-space: nowrap;
    }

    .pill-warning {
        background: #f0aeba24;
        color: #ffd7df;
    }

    .pill-danger {
        background: #ffb6bd25;
        color: #ffc3c8;
    }

    .empty {
        padding: 24px 16px !important;
        text-align: center;
        color: #e0cedb !important;
        font-size: 11px;
    }

    .empty span {
        display: block;
        margin-bottom: 8px;
        font-size: 23px;
    }

    .empty p {
        margin: 0;
        line-height: 1.7;
    }

    .report-pagination {
        margin-top: 18px;
        overflow-x: auto;
    }

    .report-page .pagination a,
    .report-page .pagination span {
        border-radius: 6px;
    }

    /* Transaksi terbaru */
    .recent-panel {
        min-width: 0;
    }

    .transaction-list {
        min-width: 0;
    }

    .transaction-row {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
        padding: 14px 0;
        border-top: 1px solid #ffffff18;
        color: inherit;
        text-decoration: none;
    }

    .transaction-row:first-child {
        border-top: none;
    }

    .transaction-row:hover {
        background: #ffffff08;
    }

    .transaction-info {
        flex: 1;
        min-width: 0;
    }

    .transaction-info strong,
    .transaction-info small {
        display: block;
        overflow-wrap: anywhere;
    }

    .transaction-value {
        max-width: 45%;
        font-size: 11px;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .recent-empty {
        border-top: 1px solid #ffffff18;
    }

    /* Tampilan layar kecil */
    @media (max-width: 1050px) {
        .report-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .report-filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .report-filter-form .filter-actions {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 650px) {
        .report-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 14px;
        }

        .report-page .page-heading h1 {
            font-size: 25px;
        }

        .report-panel {
            padding: 17px;
        }

        .value-grid,
        .recent-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .report-filter-form {
            grid-template-columns: minmax(0, 1fr);
            gap: 14px;
        }

        .report-filter-form .filter-actions {
            grid-column: auto;
        }

        .stat-card {
            min-height: 150px;
        }

        .stat-card h2 {
            font-size: 24px;
        }

        .value-card h2 {
            font-size: 25px;
        }

        .section-heading h2 {
            font-size: 19px;
        }
    }

    @media (max-width: 380px) {
        .report-stats {
            grid-template-columns: minmax(0, 1fr);
        }

        .stat-card {
            min-height: 130px;
        }

        .report-panel {
            padding: 15px;
        }

        .transaction-row {
            flex-wrap: wrap;
        }

        .transaction-value {
            max-width: 100%;
            margin-left: 46px;
            text-align: left;
        }
    }

    /* Cetak laporan */
    @media print {
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            background: white !important;
        }

        .sidebar,
        .topbar,
        .filter-panel,
        .print-btn,
        .pagination,
        .submit-row {
            display: none !important;
        }

        .main,
        .content,
        .report-page {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            color: #222 !important;
        }

        .report-panel {
            background: white !important;
            color: #222 !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            break-inside: avoid;
        }

        .report-page h1,
        .report-page h2,
        .report-page p,
        .report-page small,
        .report-page td,
        .report-page th,
        .report-page .period,
        .report-page .transaction-value,
        .report-page .transaction-info strong,
        .report-page .transaction-info small {
            color: #222 !important;
        }

        .report-page .stat-icon {
            background: #f5e8ed !important;
            color: #572b3b !important;
        }

        .report-page .report-table th {
            background: #f1e9ed !important;
        }

        .report-page .report-stats,
        .report-page .value-grid,
        .report-page .recent-grid {
            break-inside: avoid;
        }

        .report-page .transaction-row {
            border-color: #ddd !important;
        }
    }
</style>
@endsection