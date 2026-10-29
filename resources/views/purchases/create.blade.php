@extends('layouts.app')

@section('title', 'Pembelian Baru')
@section('breadcrumb', 'Pembelian / Baru')

@section('content')
    <div class="page-heading purchase-heading">
        <div>
            <h1>Pembelian Baru 🌷</h1>
            <p>Catat barang masuk dari supplier Blooming.</p>
        </div>

        <a href="{{ route('purchases.index') }}" class="btn btn-light">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form">
        @csrf

        {{-- Informasi pembelian --}}
        <section class="panel purchase-panel">
            <h2 class="section-title">Informasi Pembelian</h2>

            <div class="purchase-info-grid">
                <div class="form-group">
                    <label for="supplier_id">
                        Supplier <span class="required">*</span>
                    </label>

                    <select id="supplier_id" name="supplier_id" class="form-control" required>
                        <option value="">Pilih supplier</option>

                        @foreach ($suppliers as $supplier)
                            <option
                                value="{{ $supplier->id }}"
                                @selected(old('supplier_id') == $supplier->id)
                            >
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('supplier_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="purchase_date">
                        Tanggal Pembelian <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        id="purchase_date"
                        name="purchase_date"
                        class="form-control"
                        value="{{ old('purchase_date', now()->toDateString()) }}"
                        required
                    >

                    @error('purchase_date')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group notes-group">
                <label for="notes">Catatan</label>

                <textarea
                    id="notes"
                    name="notes"
                    class="form-control"
                    rows="3"
                    placeholder="Catatan pembelian (opsional)"
                >{{ old('notes') }}</textarea>

                @error('notes')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>
        </section>

        {{-- Produk yang dibeli --}}
        <section class="panel purchase-panel">
            <div class="items-heading">
                <div>
                    <h2 class="section-title">Produk yang Dibeli</h2>
                    <p>Tambahkan produk dan masukkan jumlah pembelian.</p>
                </div>

                <button type="button" class="btn" id="add-item">
                    + Tambah Produk
                </button>
            </div>

            @error('items')
                <div class="field-error items-error">{{ $message }}</div>
            @enderror

            <div id="purchase-items"></div>

            <div class="total-box">
                <span>Total Pembelian</span>
                <strong id="grand-total">Rp 0</strong>
            </div>
        </section>

        {{-- Tombol form --}}
        <div class="submit-row">
            <a href="{{ route('purchases.index') }}" class="btn btn-light">
                Batal
            </a>

            <button
                type="submit"
                class="btn"
                @disabled($suppliers->isEmpty() || $products->isEmpty())
            >
                Simpan Pembelian
            </button>
        </div>
    </form>

    <style>
        .purchase-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .purchase-heading h1 {
            margin-bottom: 8px;
        }

        .purchase-heading p {
            margin: 0;
            line-height: 1.7;
        }

        .purchase-panel {
            width: 100%;
            box-sizing: border-box;
            padding: 26px 28px;
            margin-bottom: 22px;
            border-radius: 14px;
        }

        .section-title {
            margin: 0 0 22px;
        }

        .purchase-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .purchase-panel .form-group {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            min-width: 0;
            margin-bottom: 20px;
        }

        .purchase-panel .form-group label {
            display: block;
            margin: 0;
            line-height: 1.5;
            font-size: 13px;
        }

        .purchase-panel .form-control {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            min-height: 43px;
            padding: 10px 13px;
            box-sizing: border-box;
            font: inherit;
            font-size: 13px;
        }

        .purchase-panel textarea.form-control {
            min-height: 95px;
            line-height: 1.6;
            resize: vertical;
        }

        .purchase-panel .notes-group {
            margin-bottom: 0;
        }

        .required,
        .field-error {
            color: #b65e58;
        }

        .field-error {
            margin-top: 2px;
            font-size: 12px;
            line-height: 1.5;
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

        .items-error {
            margin-bottom: 16px;
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
            margin-bottom: 0;
        }

        .purchase-item .form-group label {
            min-height: 20px;
        }

        .purchase-item .form-control {
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .purchase-item .btn-danger {
            min-height: 42px;
            padding: 10px 14px;
            white-space: nowrap;
            cursor: pointer;
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
            .purchase-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            .purchase-panel {
                padding: 20px 16px;
            }

            .purchase-info-grid,
            .item-grid {
                grid-template-columns: minmax(0, 1fr);
                gap: 0;
            }

            .items-heading {
                align-items: flex-start;
                flex-direction: column;
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
                        'price' => (float) $product->purchase_price,
                    ];
                })->values()
            ) }};

            const container = document.getElementById('purchase-items');
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
                    const quantity = Number(
                        row.querySelector('.quantity').value || 0
                    );

                    const price = Number(
                        row.querySelector('.unit-price').value || 0
                    );

                    const subtotal = quantity * price;

                    row.querySelector('.item-subtotal').textContent =
                        rupiah(subtotal);

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

                // Pilih produk
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

                    if (
                        oldItem &&
                        String(oldItem.product_id) === String(product.id)
                    ) {
                        option.selected = true;
                    }

                    select.appendChild(option);
                });

                productGroup.append(productLabel, select);
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

                // Harga per unit
                const priceGroup = document.createElement('div');
                priceGroup.className = 'form-group';

                const priceLabel = document.createElement('label');
                priceLabel.htmlFor = 'unit-price-' + index;
                priceLabel.textContent = 'Harga Beli/Unit *';

                const price = document.createElement('input');
                price.id = 'unit-price-' + index;
                price.type = 'number';
                price.name = 'items[' + index + '][unit_price]';
                price.className = 'form-control unit-price';
                price.min = '0';
                price.step = '0.01';
                price.value = oldItem && oldItem.unit_price !== undefined
                    ? oldItem.unit_price
                    : '';
                price.required = true;

                priceGroup.append(priceLabel, price);
                grid.appendChild(priceGroup);

                // Tombol hapus
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'btn btn-danger';
                remove.textContent = 'Hapus';
                remove.setAttribute('aria-label', 'Hapus item pembelian');

                const subtotal = document.createElement('div');
                subtotal.className = 'item-subtotal';
                subtotal.textContent = rupiah(0);

                row.append(grid, subtotal, remove);
                container.appendChild(row);

                select.addEventListener('change', function () {
                    const option = select.selectedOptions[0];

                    price.value = option && option.value !== ''
                        ? option.dataset.price
                        : '';

                    updateTotal();
                });

                quantity.addEventListener('input', updateTotal);
                price.addEventListener('input', updateTotal);

                remove.addEventListener('click', function () {
                    row.remove();
                    updateTotal();
                });

                if (oldItem && oldItem.unit_price === undefined) {
                    price.value = select.selectedOptions[0]?.dataset.price || '';
                }

                updateTotal();
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