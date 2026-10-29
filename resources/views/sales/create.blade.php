@extends('layouts.app')

@section('title', 'Penjualan Baru')
@section('breadcrumb', 'Penjualan / Baru')

@section('content')
    <div class="page-heading sales-heading">
        <div>
            <h1>Penjualan Baru 🌷</h1>
            <p>Pilih produk dan jumlah yang dibeli. Total dihitung otomatis.</p>
        </div>
        <a href="{{ route('sales.index') }}" class="btn btn-light">← Kembali</a>
    </div>

    @if ($products->isEmpty())
        <div class="alert alert-error">
            Belum ada produk. Tambahkan produk terlebih dahulu sebelum mencatat penjualan.
            <a href="{{ route('products.create') }}"><strong>Tambah Produk →</strong></a>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Transaksi belum berhasil disimpan.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST" id="sale-form">
        @csrf

        <section class="panel sales-panel">
            <h2 class="section-title">Informasi Penjualan</h2>

            <div class="form-group">
                <label for="sale_date">Tanggal Penjualan <span class="required">*</span></label>
                <input
                    type="date"
                    id="sale_date"
                    name="sale_date"
                    class="form-control"
                    value="{{ old('sale_date', now()->toDateString()) }}"
                    required
                >
            </div>

            <div class="form-group sales-notes">
                <label for="notes">Catatan</label>
                <textarea
                    id="notes"
                    name="notes"
                    class="form-control"
                    rows="3"
                    placeholder="Catatan penjualan (opsional)"
                >{{ old('notes') }}</textarea>
            </div>
        </section>

        <section class="panel sales-panel">
            <div class="items-heading">
                <div>
                    <h2 class="section-title">Produk yang Terjual</h2>
                    <p>Tambahkan produk dan tentukan jumlah yang terjual.</p>
                </div>
                <button type="button" class="btn" id="add-item">+ Tambah Produk</button>
            </div>

            <div id="sale-items"></div>

            <div class="total-box">
                <span>Total Penjualan</span>
                <strong id="grand-total">Rp 0</strong>
            </div>
        </section>

        <div class="submit-row">
            <a href="{{ route('sales.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn" @disabled($products->isEmpty())>
                Simpan Penjualan
            </button>
        </div>
    </form>

    <style>
        .sales-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .sales-heading h1 {
            margin-bottom: 8px;
        }

        .sales-heading p {
            margin: 0;
            line-height: 1.7;
        }

        .sales-panel {
            width: 100%;
            box-sizing: border-box;
            padding: 26px 28px;
            margin-bottom: 22px;
            border-radius: 14px;
        }

        .section-title {
            margin: 0 0 22px;
        }

        .sales-panel .form-group {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            min-width: 0;
            margin-bottom: 20px;
        }

        .sales-panel .form-group label {
            display: block;
            margin: 0;
            line-height: 1.5;
            font-size: 13px;
        }

        .sales-panel .form-control {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            min-height: 43px;
            padding: 10px 13px;
            box-sizing: border-box;
            font: inherit;
            font-size: 13px;
        }

        .sales-panel textarea.form-control {
            min-height: 95px;
            line-height: 1.6;
            resize: vertical;
        }

        .sales-panel .sales-notes {
            margin-bottom: 0;
        }

        .required {
            color: #b65e58;
        }

        .items-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 22px;
        }

        .items-heading .section-title {
            margin-bottom: 8px;
        }

        .items-heading p {
            margin: 0;
            font-size: 13px;
            line-height: 1.6;
            opacity: 0.8;
        }

        .items-heading > .btn {
            flex-shrink: 0;
            white-space: nowrap;
        }

        .purchase-item {
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 14px;
            min-width: 0;
        }

        .item-grid {
            display: grid;
            grid-template-columns:
                minmax(200px, 2fr)
                minmax(90px, 0.8fr)
                minmax(140px, 1fr)
                auto;
            gap: 14px;
            align-items: end;
        }

        .purchase-item .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 0;
            margin-bottom: 0;
        }

        .purchase-item .form-group label {
            min-height: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .purchase-item .form-control {
            width: 100%;
            min-width: 0;
            min-height: 43px;
            box-sizing: border-box;
            padding: 10px 12px;
        }

        .purchase-item .btn-danger {
            min-height: 42px;
            padding: 10px 14px;
            white-space: nowrap;
            cursor: pointer;
        }

        .stock-hint {
            display: block;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
            margin-top: 2px;
        }

        .item-subtotal {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid var(--border);
            font-size: 13px;
            font-weight: 700;
        }

        .item-subtotal::before {
            content: 'Subtotal item';
            font-weight: 400;
        }

        .total-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
            margin-top: 22px;
        }

        .total-box strong {
            font-size: 23px;
        }

        .submit-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin: 24px 0 32px;
        }

        .submit-row .btn {
            min-height: 42px;
            padding: 10px 18px;
            box-sizing: border-box;
            text-decoration: none;
            white-space: nowrap;
        }

        @media (max-width: 1000px) {
            .item-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px;
            }

            .purchase-item .form-group label {
                min-height: 0;
            }
        }

        @media (max-width: 650px) {
            .sales-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .sales-panel {
                padding: 20px 16px;
            }

            .items-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .item-grid {
                grid-template-columns: minmax(0, 1fr);
                gap: 0;
            }

            .purchase-item {
                padding: 16px;
            }

            .purchase-item .form-group {
                margin-bottom: 18px;
            }

            .purchase-item .btn-danger {
                width: 100%;
            }

            .total-box strong {
                font-size: 20px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const products = {{ Illuminate\Support\Js::from(
                $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'price' => (float) $product->selling_price,
                        'stock' => (int) $product->stock,
                        'unit' => $product->unit,
                    ];
                })->values()
            ) }};

            const container = document.getElementById('sale-items');
            const totalElement = document.getElementById('grand-total');
            let nextIndex = 0;

            function rupiah(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(value);
            }

            function updateTotal() {
                let total = 0;

                container.querySelectorAll('.purchase-item').forEach(function (row) {
                    const quantity = Number(row.querySelector('.quantity').value || 0);
                    const select = row.querySelector('.product-select');
                    const product = products.find(function (item) {
                        return String(item.id) === select.value;
                    });

                    const price = product ? product.price : 0;
                    const subtotal = quantity * price;

                    row.querySelector('.item-subtotal').textContent = rupiah(subtotal);
                    total += subtotal;
                });

                totalElement.textContent = rupiah(total);
            }

            function addItem(oldItem = null) {
                const index = nextIndex++;
                const row = document.createElement('div');
                row.className = 'purchase-item';

                const grid = document.createElement('div');
                grid.className = 'item-grid';

                // Produk
                const productGroup = document.createElement('div');
                productGroup.className = 'form-group';

                const productLabel = document.createElement('label');
                productLabel.htmlFor = 'product-' + index;
                productLabel.textContent = 'Produk *';

                const select = document.createElement('select');
                select.id = 'product-' + index;
                select.name = 'items[' + index + '][product_id]';
                select.className = 'form-control product-select';
                select.required = true;

                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = 'Pilih produk';
                select.appendChild(placeholder);

                products.forEach(function (product) {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = product.sku + ' — ' + product.name;
                    option.dataset.price = product.price;
                    option.dataset.stock = product.stock;
                    option.dataset.unit = product.unit;

                    if (oldItem && String(oldItem.product_id) === String(product.id)) {
                        option.selected = true;
                    }

                    select.appendChild(option);
                });

                const stockHint = document.createElement('small');
                stockHint.className = 'stock-hint';
                stockHint.textContent = 'Pilih produk untuk melihat stok tersedia.';

                productGroup.append(productLabel, select, stockHint);
                grid.appendChild(productGroup);

                // Jumlah
                const quantityGroup = document.createElement('div');
                quantityGroup.className = 'form-group';

                const quantityLabel = document.createElement('label');
                quantityLabel.htmlFor = 'quantity-' + index;
                quantityLabel.textContent = 'Jumlah *';

                const quantity = document.createElement('input');
                quantity.id = 'quantity-' + index;
                quantity.type = 'number';
                quantity.name = 'items[' + index + '][quantity]';
                quantity.className = 'form-control quantity';
                quantity.min = '1';
                quantity.step = '1';
                quantity.value = oldItem ? oldItem.quantity : '1';
                quantity.required = true;

                quantityGroup.append(quantityLabel, quantity);
                grid.appendChild(quantityGroup);

                // Harga jual otomatis
                const priceGroup = document.createElement('div');
                priceGroup.className = 'form-group';

                const priceLabel = document.createElement('label');
                priceLabel.htmlFor = 'price-' + index;
                priceLabel.textContent = 'Harga Jual/Unit';

                const priceDisplay = document.createElement('input');
                priceDisplay.id = 'price-' + index;
                priceDisplay.type = 'text';
                priceDisplay.className = 'form-control price-display';
                priceDisplay.readOnly = true;

                priceGroup.append(priceLabel, priceDisplay);
                grid.appendChild(priceGroup);

                // Tombol hapus
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'btn btn-danger';
                remove.textContent = 'Hapus';

                const subtotal = document.createElement('div');
                subtotal.className = 'item-subtotal';
                subtotal.textContent = rupiah(0);

                row.append(grid, subtotal, remove);
                container.appendChild(row);

                function updateProductInfo() {
                    const product = products.find(function (item) {
                        return String(item.id) === select.value;
                    });

                    if (product) {
                        priceDisplay.value = rupiah(product.price);
                        stockHint.textContent =
                            'Stok tersedia: ' + product.stock + ' ' + product.unit;

                        quantity.max = String(product.stock);
                    } else {
                        priceDisplay.value = '';
                        stockHint.textContent =
                            'Pilih produk untuk melihat stok tersedia.';

                        quantity.removeAttribute('max');
                    }

                    updateTotal();
                }

                select.addEventListener('change', updateProductInfo);
                quantity.addEventListener('input', updateTotal);

                remove.addEventListener('click', function () {
                    row.remove();
                    updateTotal();
                });

                updateProductInfo();
            }

            document.getElementById('add-item').addEventListener('click', function () {
                addItem();
            });

            const oldItems = {{ Illuminate\Support\Js::from(old('items', [])) }};

            if (oldItems.length > 0) {
                oldItems.forEach(function (item) {
                    addItem(item);
                });
            } else {
                addItem();
            }
        });
    </script>
@endsection