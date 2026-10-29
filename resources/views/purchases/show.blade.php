@extends('layouts.app')

@section('title', 'Detail Pembelian')
@section('breadcrumb', 'Pembelian / Detail')

@section('content')
<style>
    .purchase-page {
        color: #fff9f2;
        width: 100%;
        min-width: 0;
        font-family: 'DM Sans', sans-serif;
    }

    .purchase-page *,
    .purchase-page *::before,
    .purchase-page *::after {
        box-sizing: border-box;
    }

    .purchase-page .purchase-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 26px;
    }

    .purchase-page .eyebrow {
        display: block;
        margin-bottom: 8px;
        color: #e8a5ad;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .purchase-page .purchase-heading h1 {
        margin: 0;
        color: #fff9f2;
        font-size: 27px;
        font-weight: 700;
        line-height: 1.4;
    }

    .purchase-page .subtitle {
        margin: 8px 0 0;
        color: #e0ccd5;
        font-size: 13px;
        line-height: 1.7;
    }

    .purchase-page .action-buttons {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 9px;
    }

    .purchase-page .action-buttons form {
        display: inline-flex;
        margin: 0;
    }

    .purchase-page .purchase-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 10px 15px;
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 9px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.4;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .2s ease;
    }

    .purchase-page .btn-back {
        background: rgba(255,255,255,.08);
        color: #fff9f2;
    }

    .purchase-page .btn-back:hover {
        background: rgba(255,255,255,.15);
    }

    .purchase-page .btn-print {
        background: #e8a5ad;
        border-color: #e8a5ad;
        color: #351c2a;
    }

    .purchase-page .btn-print:hover {
        background: #f2bdc4;
    }

    .purchase-page .btn-cancel {
        background: #fae9ed;
        border-color: #e8b8c0;
        color: #963e52;
    }

    .purchase-page .btn-cancel:hover {
        background: #f4d5dc;
    }

    .purchase-page .purchase-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border-radius: 10px;
        font-size: 12px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .purchase-page .alert-success {
        color: #e8f5e4;
        background: rgba(83,137,76,.22);
        border: 1px solid rgba(153,205,143,.3);
    }

    .purchase-page .alert-error {
        color: #ffe0e0;
        background: rgba(160,57,66,.22);
        border: 1px solid rgba(255,160,160,.3);
    }

    .purchase-page .purchase-panel {
        width: 100%;
        min-width: 0;
        margin-bottom: 20px;
        padding: 23px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 15px;
        background: rgba(65,31,47,.78);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .purchase-page .panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }

    .purchase-page .panel-heading h2 {
        margin: 0;
        color: #fff9f2;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.5;
    }

    .purchase-page .panel-heading p {
        margin: 5px 0 0;
        color: #e0ccd5;
        font-size: 12px;
        line-height: 1.6;
    }

    .purchase-page .purchase-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .purchase-page .status-completed {
        color: #d7f5dc;
        background: rgba(64,142,83,.24);
        border: 1px solid rgba(142,217,157,.3);
    }

    .purchase-page .status-cancelled {
        color: #ffdce2;
        background: rgba(160,57,66,.24);
        border: 1px solid rgba(255,160,160,.3);
    }

    .purchase-page .status-other {
        color: #f1d8f4;
        background: rgba(143,104,159,.24);
        border: 1px solid rgba(210,175,222,.3);
    }

    .purchase-page .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px 28px;
    }

    .purchase-page .info-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 7px;
        min-width: 0;
    }

    .purchase-page .info-label {
        color: #d9c5ce;
        font-size: 11px;
        line-height: 1.5;
    }

    .purchase-page .info-value {
        color: #fff9f2;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .purchase-page .table-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 10px;
    }

    .purchase-page .purchase-table {
        width: 100%;
        min-width: 600px;
        border-collapse: collapse;
        margin: 0;
    }

    .purchase-page .purchase-table thead th {
        padding: 14px 15px;
        background: rgba(232,165,173,.12);
        color: #e8a5ad;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid rgba(255,255,255,.13);
    }

    .purchase-page .purchase-table tbody td {
        padding: 16px 15px;
        color: #fff9f2;
        font-size: 12px;
        line-height: 1.6;
        border-bottom: 1px solid rgba(255,255,255,.10);
        vertical-align: middle;
    }

    .purchase-page .purchase-table tbody tr:last-child td {
        border-bottom: none;
    }

    .purchase-page .purchase-table .text-right {
        text-align: right;
    }

    .purchase-page .purchase-table .text-center {
        text-align: center;
    }

    .purchase-page .product-name {
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .purchase-page .product-amount {
        color: #f3c2d0;
        font-weight: 700;
        white-space: nowrap;
    }

    .purchase-page .empty-state {
        padding: 25px !important;
        text-align: center;
        color: #d9c5ce !important;
    }

    .purchase-page .purchase-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 16px;
        padding: 19px 20px;
        border: 1px solid rgba(232,165,173,.25);
        border-radius: 11px;
        background: linear-gradient(
            120deg,
            rgba(232,165,173,.13),
            rgba(100,57,92,.35)
        );
    }

    .purchase-page .purchase-total span {
        color: #e7d8df;
        font-size: 13px;
        font-weight: 600;
    }

    .purchase-page .purchase-total strong {
        color: #fff1f5;
        font-size: 22px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .purchase-page .notes-content {
        padding: 15px;
        color: #fff9f2;
        background: rgba(255,255,255,.045);
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 10px;
        font-size: 12px;
        line-height: 1.8;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .purchase-page .muted {
        color: #d9c5ce;
    }

    .purchase-page .purchase-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 5px 2px 12px;
        color: #d9c5ce;
        font-size: 10px;
    }

    @media (max-width: 700px) {
        .purchase-page .purchase-heading h1 {
            font-size: 23px;
        }

        .purchase-page .purchase-panel {
            padding: 17px;
        }

        .purchase-page .info-grid {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .purchase-page .action-buttons {
            justify-content: flex-start;
            width: 100%;
        }

        .purchase-page .purchase-total strong {
            font-size: 19px;
        }
    }

    @media print {
        body {
            background: white !important;
            color: black !important;
        }

        .bloom-sidebar,
        .bloom-topbar {
            display: none !important;
        }

        .bloom-layout {
            display: block !important;
        }

        .bloom-main,
        .bloom-content {
            width: 100% !important;
            max-width: none !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: visible !important;
        }

        .purchase-page {
            color: black !important;
        }

        .purchase-page .action-buttons,
        .purchase-page .purchase-alert {
            display: none !important;
        }

        .purchase-page .purchase-panel {
            background: white !important;
            color: black !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            break-inside: avoid;
        }

        .purchase-page .purchase-heading h1,
        .purchase-page .panel-heading h2,
        .purchase-page .info-value,
        .purchase-page .purchase-table tbody td,
        .purchase-page .purchase-total strong,
        .purchase-page .purchase-total span,
        .purchase-page .notes-content,
        .purchase-page .purchase-footer {
            color: black !important;
        }

        .purchase-page .subtitle,
        .purchase-page .panel-heading p,
        .purchase-page .info-label {
            color: #555 !important;
        }

        .purchase-page .purchase-table {
            min-width: 0 !important;
        }

        .purchase-page .purchase-table thead th {
            background: #f3f3f3 !important;
            color: black !important;
        }

        .purchase-page .purchase-total,
        .purchase-page .notes-content {
            background: white !important;
            border: 1px solid #ddd !important;
        }

        .purchase-page .table-wrapper {
            overflow: visible !important;
        }
    }
</style>

<div class="purchase-page">

    @if (session('success'))
        <div class="purchase-alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="purchase-alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->has('purchase'))
        <div class="purchase-alert alert-error">
            {{ $errors->first('purchase') }}
        </div>
    @endif

    <div class="purchase-heading">
        <div>
            <span class="eyebrow">BLOOMING INVENTORY</span>
            <h1>Detail Pembelian 🌷</h1>
            <p class="subtitle">
                Informasi lengkap transaksi pembelian produk.
            </p>
        </div>

        <div class="action-buttons">
            <a
                href="{{ route('purchases.index') }}"
                class="purchase-btn btn-back"
            >
                ← Kembali
            </a>

            <button
                type="button"
                onclick="window.print()"
                class="purchase-btn btn-print"
            >
                Cetak
            </button>

            @if (
                auth()->check() &&
                auth()->user()->role === 'admin' &&
                $purchase->status === 'completed'
            )
                <form
                    action="{{ route('purchases.cancel', $purchase) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan pembelian ini? Stok produk akan dikurangi kembali.');"
                >
                    @csrf

                    <button
                        type="submit"
                        class="purchase-btn btn-cancel"
                    >
                        Batalkan Pembelian
                    </button>
                </form>
            @endif
        </div>
    </div>

    <section class="purchase-panel">
        <div class="panel-heading">
            <div>
                <h2>Informasi Transaksi</h2>
                <p>Data utama pembelian dan pemasok.</p>
            </div>

            @if ($purchase->status === 'completed')
                <span class="purchase-status status-completed">
                    ✓ Selesai
                </span>
            @elseif ($purchase->status === 'cancelled')
                <span class="purchase-status status-cancelled">
                    ✕ Dibatalkan
                </span>
            @else
                <span class="purchase-status status-other">
                    {{ ucfirst($purchase->status) }}
                </span>
            @endif
        </div>

        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nomor Pembelian</span>
                <strong class="info-value">
                    {{ $purchase->purchase_number }}
                </strong>
            </div>

            <div class="info-item">
                <span class="info-label">Pemasok</span>
                <strong class="info-value">
                    {{ $purchase->supplier->name ?? '-' }}
                </strong>
            </div>

            <div class="info-item">
                <span class="info-label">Tanggal Pembelian</span>
                <strong class="info-value">
                    {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}
                </strong>
            </div>

            <div class="info-item">
                <span class="info-label">Dibuat Oleh</span>
                <strong class="info-value">
                    {{ $purchase->user->name ?? '-' }}
                </strong>
            </div>
        </div>
    </section>

    <section class="purchase-panel">
        <div class="panel-heading">
            <div>
                <h2>Produk yang Dibeli</h2>
                <p>
                    {{ $purchase->items->count() }}
                    jenis produk dalam transaksi ini.
                </p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="purchase-table">
                <thead>
                    <tr>
                        <th style="width: 55px;">No.</th>
                        <th>Nama Produk</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($purchase->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <div class="product-name">
                                    {{ $item->product->name ?? 'Produk tidak tersedia' }}
                                </div>
                            </td>

                            <td class="text-right">
                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                {{ number_format($item->quantity, 0, ',', '.') }}
                            </td>

                            <td class="text-right product-amount">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                Belum ada produk dalam transaksi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="purchase-total">
            <span>Total Pembelian</span>

            <strong>
                Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
            </strong>
        </div>
    </section>

    <section class="purchase-panel">
        <div class="panel-heading">
            <div>
                <h2>Catatan Pembelian</h2>
                <p>Catatan tambahan untuk transaksi ini.</p>
            </div>
        </div>

        <div class="notes-content">
            @if ($purchase->notes)
                {{ $purchase->notes }}
            @else
                <span class="muted">Tidak ada catatan pembelian.</span>
            @endif
        </div>
    </section>

    <div class="purchase-footer">
        <span>Blooming Inventory</span>
        <span>Flower with care, manage with love.</span>
    </div>

</div>
@endsection