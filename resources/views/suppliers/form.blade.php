{{-- Nama supplier --}}
<div class="supplier-fields">

    <div class="form-group">
        <label for="name">
            Nama Supplier <span class="required">*</span>
        </label>

        <input
            id="name"
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $supplier->name) }}"
            maxlength="255"
            placeholder="Contoh: Nusantara Flower Farm"
            required
        >

        @error('name')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- Kontak person --}}
    <div class="form-group">
        <label for="contact_person">Nama Kontak Person</label>

        <input
            id="contact_person"
            type="text"
            name="contact_person"
            class="form-control"
            value="{{ old('contact_person', $supplier->contact_person) }}"
            maxlength="255"
            placeholder="Nama orang yang bisa dihubungi"
        >

        @error('contact_person')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    {{-- Telepon dan email --}}
    <div class="form-row">
        <div class="form-group">
            <label for="phone">Nomor Telepon</label>

            <input
                id="phone"
                type="text"
                name="phone"
                class="form-control"
                value="{{ old('phone', $supplier->phone) }}"
                maxlength="30"
                placeholder="08xxxxxxxxxx"
            >

            @error('phone')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>

            <input
                id="email"
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email', $supplier->email) }}"
                maxlength="255"
                placeholder="supplier@email.com"
            >

            @error('email')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Alamat --}}
    <div class="form-group">
        <label for="address">Alamat</label>

        <textarea
            id="address"
            name="address"
            class="form-control"
            rows="4"
            maxlength="2000"
            placeholder="Alamat supplier (opsional)"
        >{{ old('address', $supplier->address) }}</textarea>

        @error('address')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

</div>

<style>
    /* Susunan form */
    .supplier-fields {
        width: 100%;
        min-width: 0;
    }

    .supplier-fields .form-group {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
        width: 100%;
        min-width: 0;
        margin-bottom: 22px;
    }

    /* Label */
    .supplier-fields .form-group label {
        display: block;
        margin: 0;
        line-height: 1.5;
        font-size: 13px;
    }

    /* Input mengikuti warna tema asli */
    .supplier-fields .form-control {
        display: block;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        min-height: 43px;
        padding: 10px 13px;
        box-sizing: border-box;
        font: inherit;
        font-size: 13px;
    }

    /* Alamat */
    .supplier-fields textarea.form-control {
        min-height: 115px;
        line-height: 1.6;
        resize: vertical;
    }

    /* Telepon dan email dalam dua kolom */
    .supplier-fields .form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
        width: 100%;
        min-width: 0;
    }

    .supplier-fields .form-row > * {
        min-width: 0;
    }

    /* Pesan validasi */
    .supplier-fields .required,
    .supplier-fields .field-error {
        color: #b65e58;
    }

    .supplier-fields .field-error {
        margin-top: 0;
        font-size: 12px;
        line-height: 1.5;
    }

    /* Tampilan layar kecil */
    @media (max-width: 600px) {
        .supplier-fields .form-row {
            grid-template-columns: minmax(0, 1fr);
            gap: 0;
        }
    }
</style>