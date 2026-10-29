@extends('layouts.app')

@section('title', 'Detail Supplier')
@section('breadcrumb', 'Supplier / Detail')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Detail Supplier ✿</h1>
            <p>Informasi pemasok dan riwayat pembelian terbaru.</p>
        </div>
        <div class="heading-actions">
            <a href="{{ route('suppliers.index') }}" class="btn btn-light">← Kembali</a>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn">Edit Supplier</a>
        </div>
    </div>

    <div class="supplier-detail-grid">
        <section class="panel">
            <div class="supplier-flower">❀</div>
            <div class="detail-label">Nama Supplier</div>
            <h2>{{ $supplier->name }}</h2>

            <div class="detail-label">Kontak Person</div>
            <p>{{ $supplier->contact_person ?: '—' }}</p>

            <div class="detail-label">Nomor Telepon</div>
            <p>{{ $supplier->phone ?: '—' }}</p>

            <div class="detail-label">Email</div>
            <p>{{ $supplier->email ?: '—' }}</p>

            <div class="detail-label">Alamat</div>
            <p class="address">{{ $supplier->address ?: 'Belum ada alamat.' }}</p>

            <div class="detail-label">Terdaftar Sejak</div>
            <p>{{ $supplier->created_at?->format('d F Y') ?? '—' }}</p>
        </section>

        <section class="panel">
            <h2>Riwayat Pembelian Terbaru</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No. Pembelian</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supplier->purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->purchase_number }}</td>
                                <td>{{ $purchase->purchase_date?->format('d/m/Y') ?? '—' }}</td>
                                <td>Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($purchase->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <span>🌷</span>
                                    <p>Belum ada transaksi pembelian dari supplier ini.</p>
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
        .supplier-detail-grid { display: grid; grid-template-columns: 0.8fr 1.2fr; gap: 20px; }
        .supplier-flower { font-size: 36px; color: var(--sage); }
        .detail-label { margin-top: 22px; color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .address { white-space: pre-line; line-height: 1.8; }
        @media (max-width: 800px) { .supplier-detail-grid { grid-template-columns: 1fr; } }
    </style>
@endsection