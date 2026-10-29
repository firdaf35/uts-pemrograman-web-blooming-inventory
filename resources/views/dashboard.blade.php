@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="bloom-dashboard">

    <section class="welcome-hero">
        <div class="hero-content">
            <span class="hero-eyebrow">✿ YOUR LITTLE BOTANICAL WORLD</span>
            <h1>Good day, {{ auth()->user()->name ?? 'Blooming User' }}.</h1>
            <p>Setiap bunga punya cerita. Kelola setiap detail bisnis Blooming dengan lebih mudah hari ini.</p>

            <div class="hero-actions">
                <a href="{{ route('sales.create') }}" class="hero-button">＋ Buat Penjualan</a>
                <a href="{{ route('purchases.create') }}" class="hero-link">Catat Pembelian ↗</a>
            </div>
        </div>
        <div class="hero-flower">✿</div>
        <div class="hero-decoration">blooming.</div>
    </section>

    <div class="section-intro">
        <div>
            <span class="section-kicker">OVERVIEW</span>
            <h2>Ringkasan Toko</h2>
        </div>
        <div class="date-chip">◷ {{ now()->translatedFormat('d F Y') }}</div>
    </div>

    <section class="stats-grid">
        <article class="glass-card stat-card featured">
            <div class="stat-top"><span>Total Produk</span><span class="stat-icon">🌷</span></div>
            <div class="stat-number">{{ number_format($totalProducts ?? 0) }}</div>
            <p>Produk terdaftar di inventory</p>
            <a href="{{ route('products.index') }}">Lihat produk ↗</a>
        </article>

        <article class="glass-card stat-card">
            <div class="stat-top"><span>Total Stok</span><span class="stat-icon">✾</span></div>
            <div class="stat-number">{{ number_format($totalStock ?? 0) }}</div>
            <p>Unit seluruh persediaan</p>
            <a href="{{ route('products.index') }}">Cek inventory ↗</a>
        </article>

        <article class="glass-card stat-card">
            <div class="stat-top"><span>Kategori</span><span class="stat-icon">❀</span></div>
            <div class="stat-number">{{ number_format($totalCategories ?? 0) }}</div>
            <p>Kategori produk</p>
            <a href="{{ route('categories.index') }}">Lihat kategori ↗</a>
        </article>

        <article class="glass-card stat-card">
            <div class="stat-top"><span>Supplier</span><span class="stat-icon">✿</span></div>
            <div class="stat-number">{{ number_format($totalSuppliers ?? 0) }}</div>
            <p>Pemasok terdaftar</p>
            <a href="{{ route('suppliers.index') }}">Lihat supplier ↗</a>
        </article>
    </section>

    <div class="section-intro section-spaced">
        <div>
            <span class="section-kicker">BUSINESS PERFORMANCE</span>
            <h2>Aktivitas Bisnis</h2>
        </div>
        <a href="{{ route('reports.index') }}" class="text-link">Lihat laporan lengkap ↗</a>
    </div>

    <section class="performance-grid">
        <article class="glass-card performance-card">
            <div class="performance-symbol">↗</div>
            <span>Penjualan Hari Ini</span>
            <h3>Rp {{ number_format($salesToday ?? 0, 0, ',', '.') }}</h3>
            <p>{{ $salesCountToday ?? 0 }} transaksi selesai hari ini</p>
        </article>

        <article class="glass-card performance-card">
            <div class="performance-symbol">↙</div>
            <span>Pembelian Hari Ini</span>
            <h3>Rp {{ number_format($purchasesToday ?? 0, 0, ',', '.') }}</h3>
            <p>Total pembelian yang selesai hari ini</p>
        </article>

        <article class="glass-card performance-card">
            <div class="performance-symbol">♡</div>
            <span>Penjualan Bulan Ini</span>
            <h3>Rp {{ number_format($salesThisMonth ?? 0, 0, ',', '.') }}</h3>
            <p>Akumulasi sejak awal bulan</p>
        </article>
    </section>

    <section class="dashboard-columns">
        <article class="glass-card dashboard-panel">
            <div class="panel-heading">
                <div>
                    <span class="section-kicker">INVENTORY ALERT</span>
                    <h2>Low Stock Alert</h2>
                    <p>Produk yang perlu segera diperiksa.</p>
                </div>
                <span class="alert-count">{{ $lowStockCount ?? 0 }}</span>
            </div>

            @forelse (($lowStockProducts ?? collect()) as $product)
                <div class="stock-row">
                    <div class="stock-flower">✿</div>
                    <div class="stock-info">
                        <strong>{{ $product->name }}</strong>
                        <span>{{ $product->category?->name ?? 'Tanpa kategori' }} · SKU {{ $product->sku }}</span>
                    </div>
                    <div class="stock-quantity {{ $product->stock == 0 ? 'stock-empty' : '' }}">
                        <strong>{{ $product->stock }}</strong>
                        <span>{{ $product->stock == 0 ? 'Habis' : $product->unit }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-dashboard">
                    <span>🌿</span>
                    <strong>Belum ada data stok</strong>
                    <p>Produk dengan stok rendah akan muncul di sini.</p>
                </div>
            @endforelse

            <a href="{{ route('products.index') }}" class="panel-footer-link">Kelola produk & stok ↗</a>
        </article>

        <article class="glass-card dashboard-panel">
            <div class="panel-heading">
                <div>
                    <span class="section-kicker">LATEST TRANSACTIONS</span>
                    <h2>Recent Sales</h2>
                    <p>Riwayat penjualan terbaru.</p>
                </div>
                <a href="{{ route('sales.index') }}" class="mini-link">Semua ↗</a>
            </div>

            @forelse (($recentSales ?? collect()) as $sale)
                <a href="{{ route('sales.show', $sale) }}" class="sale-row">
                    <div class="sale-symbol">♡</div>
                    <div class="sale-info">
                        <strong>{{ $sale->sale_number }}</strong>
                        <span>{{ $sale->user?->name ?? 'Petugas' }} · {{ $sale->sale_date?->format('d/m/Y') ?? '—' }}</span>
                    </div>
                    <div class="sale-amount">
                        <strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong>
                        <span>{{ $sale->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}</span>
                    </div>
                </a>
            @empty
                <div class="empty-dashboard">
                    <span>🌷</span>
                    <strong>Belum ada penjualan</strong>
                    <p>Transaksi penjualan akan muncul di sini.</p>
                </div>
            @endforelse

            <a href="{{ route('sales.index') }}" class="panel-footer-link">Lihat seluruh penjualan ↗</a>
        </article>
    </section>

    <section class="glass-card purchases-panel">
        <div class="panel-heading">
            <div>
                <span class="section-kicker">STOCK IN</span>
                <h2>Pembelian Terbaru</h2>
                <p>Barang yang baru dicatat masuk ke inventory.</p>
            </div>
            <a href="{{ route('purchases.index') }}" class="mini-link">Semua ↗</a>
        </div>

        <div class="table-wrap">
            <table class="bloom-table">
                <thead>
                    <tr><th>Nomor Pembelian</th><th>Supplier</th><th>Tanggal</th><th>Total</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse (($recentPurchases ?? collect()) as $purchase)
                        <tr>
                            <td><a href="{{ route('purchases.show', $purchase) }}" class="table-transaction">{{ $purchase->purchase_number }}</a></td>
                            <td>{{ $purchase->supplier?->name ?? '—' }}</td>
                            <td>{{ $purchase->purchase_date?->format('d/m/Y') ?? '—' }}</td>
                            <td>Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                            <td><span class="table-status {{ $purchase->status === 'completed' ? 'is-complete' : 'is-cancelled' }}">{{ $purchase->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="table-empty">Belum ada transaksi pembelian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <footer class="dashboard-footer">
        <span>blooming<span class="footer-dot">.</span></span>
        <p>Made with love for every little detail. ✿</p>
    </footer>
</div>

<style>
.bloom-dashboard {
    --wine:#54243b;
    --plum:#291524;
    --rose:#f0a8b7;
    --cream:#fff8f4;
    color:var(--cream);
}
.bloom-dashboard .welcome-hero {
    position:relative;display:flex;align-items:center;min-height:245px;
    overflow:hidden;padding:36px;margin-bottom:30px;border-radius:20px;
    border:1px solid rgba(255,255,255,.24);
    background:linear-gradient(105deg,rgba(36,15,29,.96),rgba(83,35,58,.82),rgba(83,35,58,.38)),
    url('https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=1600&q=85') center/cover;
    box-shadow:0 18px 45px rgba(20,8,15,.2);
}
.bloom-dashboard .hero-content{position:relative;z-index:2;max-width:570px}
.bloom-dashboard .hero-eyebrow,.bloom-dashboard .section-kicker{color:#ffc0cc;font-size:9px;font-weight:700;letter-spacing:2px}
.bloom-dashboard .welcome-hero h1{margin:15px 0 10px;font-family:'Playfair Display',serif;font-size:clamp(27px,3vw,39px);font-weight:500;line-height:1.25}
.bloom-dashboard .welcome-hero p{max-width:430px;color:rgba(255,248,244,.85);font-size:12px;line-height:1.9}
.bloom-dashboard .hero-actions{display:flex;align-items:center;flex-wrap:wrap;gap:19px;margin-top:22px}
.bloom-dashboard .hero-button{padding:12px 17px;border-radius:9px;background:var(--rose);color:#351626;font-size:11px;font-weight:700}
.bloom-dashboard .hero-button:hover{background:#ffc9d2}
.bloom-dashboard .hero-link{color:#fff8f4;font-size:11px}
.bloom-dashboard .hero-flower{position:absolute;top:50%;right:8%;transform:translateY(-50%) rotate(-14deg);color:rgba(255,190,205,.68);font-size:clamp(100px,15vw,180px);pointer-events:none}
.bloom-dashboard .hero-decoration{position:absolute;right:20px;bottom:3px;color:rgba(255,255,255,.07);font-family:'Playfair Display',serif;font-size:clamp(45px,8vw,95px)}
.bloom-dashboard .section-intro{display:flex;justify-content:space-between;align-items:end;gap:14px;margin:0 0 16px}
.bloom-dashboard .section-intro h2,.bloom-dashboard .panel-heading h2{margin:6px 0 0;color:#fff8f4;font-family:'Playfair Display',serif;font-size:23px;font-weight:500}
.bloom-dashboard .date-chip{padding:9px 12px;border:1px solid rgba(255,255,255,.2);border-radius:9px;background:rgba(255,255,255,.1);color:#fff8f4;backdrop-filter:blur(14px);font-size:10px}
.bloom-dashboard .stats-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
.bloom-dashboard .stat-card{min-width:0;padding:20px;overflow:hidden;border:1px solid rgba(255,255,255,.2);border-radius:15px;background:linear-gradient(145deg,rgba(100,45,70,.88),rgba(42,21,36,.88));box-shadow:0 12px 30px rgba(20,8,15,.15);backdrop-filter:blur(18px);transition:.2s}
.bloom-dashboard .stat-card:hover{transform:translateY(-3px);border-color:rgba(240,168,183,.6)}
.bloom-dashboard .stat-card.featured{background:linear-gradient(145deg,rgba(157,68,99,.92),rgba(78,31,54,.94))}
.bloom-dashboard .stat-top{display:flex;justify-content:space-between;align-items:center;gap:8px;color:#fbe8ed;font-size:11px;font-weight:600}
.bloom-dashboard .stat-icon{display:flex;align-items:center;justify-content:center;flex:0 0 35px;width:35px;height:35px;border:1px solid rgba(255,255,255,.16);border-radius:11px;background:rgba(255,255,255,.1);font-size:17px}
.bloom-dashboard .stat-number{margin-top:22px;color:#fff8f4;font-family:'Playfair Display',serif;font-size:34px;line-height:1.15;overflow-wrap:anywhere}
.bloom-dashboard .stat-card p{min-height:27px;margin:9px 0;color:rgba(255,248,244,.72);font-size:10px;line-height:1.7}
.bloom-dashboard .stat-card>a,.bloom-dashboard .text-link,.bloom-dashboard .mini-link{color:#ffc0cc;font-size:10px;font-weight:700}
.bloom-dashboard .section-spaced{margin-top:31px}
.bloom-dashboard .performance-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
.bloom-dashboard .performance-card,.bloom-dashboard .dashboard-panel,.bloom-dashboard .purchases-panel{min-width:0;padding:21px;border:1px solid rgba(255,255,255,.2);border-radius:15px;background:linear-gradient(145deg,rgba(255,255,255,.14),rgba(255,255,255,.055));box-shadow:0 12px 35px rgba(24,10,18,.08);backdrop-filter:blur(17px)}
.bloom-dashboard .performance-symbol{display:flex;align-items:center;justify-content:center;width:34px;height:34px;margin-bottom:15px;border-radius:10px;background:rgba(240,168,183,.18);color:#ffc0cc;font-size:19px}
.bloom-dashboard .performance-card>span{color:rgba(255,248,244,.84);font-size:11px}
.bloom-dashboard .performance-card h3{margin:10px 0;color:#fff8f4;font-family:'Playfair Display',serif;font-size:clamp(18px,2vw,27px);font-weight:500;overflow-wrap:anywhere}
.bloom-dashboard .performance-card p,.bloom-dashboard .panel-heading p{margin:8px 0 0;color:rgba(255,248,244,.68);font-size:10px;line-height:1.7}
.bloom-dashboard .dashboard-columns{display:grid;grid-template-columns:1fr 1fr;gap:17px;align-items:start;margin-top:29px}
.bloom-dashboard .panel-heading{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:18px}
.bloom-dashboard .panel-heading h2{font-size:21px}
.bloom-dashboard .alert-count{display:flex;align-items:center;justify-content:center;flex:0 0 32px;height:32px;border:1px solid rgba(240,168,183,.3);border-radius:9px;background:rgba(240,168,183,.15);color:#ffc0cc;font-size:12px;font-weight:700}
.bloom-dashboard .stock-row,.bloom-dashboard .sale-row{display:flex;align-items:center;gap:11px;padding:13px 0;border-top:1px solid rgba(255,255,255,.12)}
.bloom-dashboard .stock-flower,.bloom-dashboard .sale-symbol{display:flex;align-items:center;justify-content:center;flex:0 0 34px;width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,.1);color:#ffc0cc}
.bloom-dashboard .stock-info,.bloom-dashboard .sale-info{flex:1;min-width:0}
.bloom-dashboard .stock-info strong,.bloom-dashboard .sale-info strong{display:block;color:#fff8f4;font-size:11px;overflow-wrap:anywhere}
.bloom-dashboard .stock-info span,.bloom-dashboard .sale-info span{display:block;margin-top:5px;color:rgba(255,248,244,.65);font-size:9px;line-height:1.6;overflow-wrap:anywhere}
.bloom-dashboard .stock-quantity,.bloom-dashboard .sale-amount{flex-shrink:0;text-align:right}
.bloom-dashboard .stock-quantity strong{display:block;color:#fff8f4;font-size:14px}
.bloom-dashboard .stock-quantity span,.bloom-dashboard .sale-amount span{color:rgba(255,248,244,.65);font-size:9px}
.bloom-dashboard .stock-empty strong,.bloom-dashboard .stock-empty span{color:#ffc4c8}
.bloom-dashboard .sale-row{color:inherit;text-decoration:none}
.bloom-dashboard .sale-row:hover{background:rgba(255,255,255,.05)}
.bloom-dashboard .sale-amount strong{display:block;max-width:145px;color:#fff8f4;font-size:10px;overflow-wrap:anywhere}
.bloom-dashboard .sale-amount span{display:block;margin-top:5px;color:#ffc0cc}
.bloom-dashboard .panel-footer-link{display:block;padding-top:15px;margin-top:6px;border-top:1px solid rgba(255,255,255,.12);color:#ffc0cc;font-size:10px;font-weight:600}
.bloom-dashboard .empty-dashboard{display:flex;flex-direction:column;align-items:center;padding:24px 10px;text-align:center}
.bloom-dashboard .empty-dashboard>span{font-size:28px}
.bloom-dashboard .empty-dashboard strong{margin-top:12px;color:#fff8f4;font-family:'Playfair Display',serif;font-size:16px;font-weight:500}
.bloom-dashboard .empty-dashboard p{color:rgba(255,248,244,.65);font-size:10px;line-height:1.7}
.bloom-dashboard .purchases-panel{margin-top:18px}
.bloom-dashboard .bloom-table{min-width:550px;color:#fff8f4}
.bloom-dashboard .bloom-table th{background:rgba(255,255,255,.09);color:rgba(255,248,244,.78)}
.bloom-dashboard .bloom-table td{border-bottom-color:rgba(255,255,255,.1);color:rgba(255,248,244,.88)}
.bloom-dashboard .table-transaction{color:#ffc0cc;font-weight:600}
.bloom-dashboard .table-status{display:inline-block;padding:6px 8px;border-radius:6px;font-size:9px}
.bloom-dashboard .is-complete{background:rgba(139,184,130,.18);color:#c5e8bd}
.bloom-dashboard .is-cancelled{background:rgba(240,168,183,.15);color:#ffc4c8}
.bloom-dashboard .table-empty{padding:25px;color:rgba(255,248,244,.65);text-align:center}
.bloom-dashboard .dashboard-footer{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-top:27px;padding-top:18px;border-top:1px solid rgba(255,255,255,.16)}
.bloom-dashboard .dashboard-footer>span{color:#fff8f4;font-family:'Playfair Display',serif;font-size:21px}
.bloom-dashboard .footer-dot{color:#ffc0cc}
.bloom-dashboard .dashboard-footer p{color:rgba(255,248,244,.65);font-size:10px}
@media(max-width:1100px){.bloom-dashboard .stats-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.bloom-dashboard .hero-flower{right:3%;opacity:.45}}
@media(max-width:800px){.bloom-dashboard .dashboard-columns{grid-template-columns:1fr}.bloom-dashboard .performance-grid{grid-template-columns:1fr}.bloom-dashboard .welcome-hero{padding:27px}}
@media(max-width:650px){.bloom-dashboard .stats-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.bloom-dashboard .stat-card{padding:15px}.bloom-dashboard .stat-number{font-size:27px}.bloom-dashboard .section-intro{align-items:flex-start}.bloom-dashboard .hero-flower{top:20px;right:-20px;transform:none;font-size:95px}.bloom-dashboard .dashboard-panel,.bloom-dashboard .purchases-panel{padding:16px}.bloom-dashboard .dashboard-footer{align-items:flex-start;flex-direction:column;gap:5px}}
@media(max-width:420px){.bloom-dashboard .stats-grid{grid-template-columns:1fr}}
@media print{.bloom-dashboard .welcome-hero{print-color-adjust:exact}.sidebar,.topbar{display:none!important}.main{margin:0!important}}
</style>
@endsection