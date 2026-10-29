@php
    $isEdit = $product->exists;
@endphp

<div class="product-fields">

    {{-- Kategori --}}
    <div class="form-group">
        <label for="category_id">
            Kategori <span class="required">*</span>
        </label>

        <select id="category_id" name="category_id" class="form-control" required>
            <option value="">Pilih kategori</option>

            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected((string) old('category_id', $product->category_id) === (string) $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- SKU --}}
    <div class="form-group">
        <label for="sku">
            SKU / Kode Produk <span class="required">*</span>
        </label>

        <input
            id="sku"
            type="text"
            name="sku"
            class="form-control"
            value="{{ old('sku', $product->sku) }}"
            maxlength="100"
            placeholder="Contoh: BLM-001"
            required
        >

        @error('sku')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- Nama produk --}}
    <div class="form-group">
        <label for="name">
            Nama Produk <span class="required">*</span>
        </label>

        <input
            id="name"
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $product->name) }}"
            maxlength="255"
            placeholder="Contoh: Buket Mawar Pink"
            required
        >

        @error('name')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div class="form-group">
        <label for="description">Deskripsi</label>

        <textarea
            id="description"
            name="description"
            class="form-control"
            rows="4"
            maxlength="2000"
            placeholder="Deskripsi produk (opsional)"
        >{{ old('description', $product->description) }}</textarea>

        @error('description')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- Satuan --}}
    <div class="form-group">
        <label for="unit">
            Satuan <span class="required">*</span>
        </label>

        <select id="unit" name="unit" class="form-control" required>
            @foreach (['pcs', 'buket', 'tangkai', 'papan', 'pot', 'paket'] as $unit)
                <option
                    value="{{ $unit }}"
                    @selected(old('unit', $product->unit ?: 'pcs') === $unit)
                >
                    {{ ucfirst($unit) }}
                </option>
            @endforeach
        </select>

        @error('unit')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- Harga --}}
    <div class="form-row">
        <div class="form-group">
            <label for="purchase_price">
                Harga Beli (Rp) <span class="required">*</span>
            </label>

            <input
                id="purchase_price"
                type="number"
                name="purchase_price"
                class="form-control"
                value="{{ old('purchase_price', $product->purchase_price ?? 0) }}"
                min="0"
                step="0.01"
                required
            >

            @error('purchase_price')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="selling_price">
                Harga Jual (Rp) <span class="required">*</span>
            </label>

            <input
                id="selling_price"
                type="number"
                name="selling_price"
                class="form-control"
                value="{{ old('selling_price', $product->selling_price ?? 0) }}"
                min="0"
                step="0.01"
                required
            >

            @error('selling_price')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Stok --}}
    <div class="form-row">
        <div class="form-group">
            <label for="stock">
                Stok Awal <span class="required">*</span>
            </label>

            <input
                id="stock"
                type="number"
                name="stock"
                class="form-control"
                value="{{ old('stock', $product->stock ?? 0) }}"
                min="0"
                step="1"
                required
            >

            @error('stock')
                <div class="field-error">{{ $message }}</div>
            @enderror

            @if ($isEdit)
                <small class="form-hint">
                    Untuk menjaga catatan persediaan, perubahan stok sebaiknya
                    dicatat melalui transaksi pembelian atau penyesuaian stok.
                </small>
            @endif
        </div>

        <div class="form-group">
            <label for="minimum_stock">
                Batas Minimum Stok <span class="required">*</span>
            </label>

            <input
                id="minimum_stock"
                type="number"
                name="minimum_stock"
                class="form-control"
                value="{{ old('minimum_stock', $product->minimum_stock ?? 0) }}"
                min="0"
                step="1"
                required
            >

            @error('minimum_stock')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>

<style>
    /* Susunan seluruh field */
    .product-fields {
        width: 100%;
        min-width: 0;
    }

    .product-fields .form-group {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
        width: 100%;
        min-width: 0;
        margin-bottom: 22px;
    }

    /* Label */
    .product-fields .form-group label {
        display: block;
        margin: 0;
        line-height: 1.5;
        font-size: 13px;
    }

    /* Input dan dropdown: warna mengikuti tema asli */
    .product-fields .form-control {
        display: block;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        min-height: 43px;
        box-sizing: border-box;
        padding: 10px 13px;
        font: inherit;
        font-size: 13px;
    }

    .product-fields textarea.form-control {
        min-height: 115px;
        line-height: 1.6;
        resize: vertical;
    }

    /* Harga dan stok dalam dua kolom */
    .product-fields .form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
        width: 100%;
        min-width: 0;
    }

    .product-fields .form-row .form-group {
        min-width: 0;
    }

    /* Pesan validasi */
    .product-fields .required,
    .product-fields .field-error {
        color: #b65e58;
    }

    .product-fields .field-error {
        margin-top: 0;
        font-size: 12px;
        line-height: 1.5;
    }

    .product-fields .form-hint {
        display: block;
        margin-top: 2px;
        color: var(--muted);
        font-size: 11px;
        line-height: 1.6;
    }

    /* Layar kecil */
    @media (max-width: 600px) {
        .product-fields .form-row {
            grid-template-columns: minmax(0, 1fr);
            gap: 0;
        }
    }
</style>