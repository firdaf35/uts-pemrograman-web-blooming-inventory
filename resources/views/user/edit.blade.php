@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('breadcrumb', 'Manajemen Pengguna / Edit')

@section('content')
<div class="user-form-page">
    <div class="page-heading">
        <div>
            <span class="eyebrow">BLOOMING · TEAM MANAGEMENT</span>
            <h1>Edit Pengguna ✿</h1>
            <p>Perbarui informasi akun {{ $user->name }}.</p>
        </div>
        <a href="{{ route('users.index') }}" class="bloom-btn secondary">← Kembali</a>
    </div>

    <section class="glass-panel">
        <div class="form-title">
            <span class="flower-icon">✿</span>
            <div>
                <h2>Informasi Akun</h2>
                <p>ID pengguna: #{{ $user->id }}</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="notice error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" class="bloom-input"
                       value="{{ old('name', $user->name) }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="bloom-input"
                       value="{{ old('email', $user->email) }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="role">Role Pengguna</label>
                <select id="role" name="role" class="bloom-input" required>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    <option value="staff" @selected(old('role', $user->role) === 'staff')>Staff</option>
                </select>

                @if ($user->id === auth()->id())
                    <small>Akun yang sedang kamu gunakan harus tetap memiliki role Admin.</small>
                @endif
            </div>

            <div class="password-note">
                Kosongkan bagian password jika kamu tidak ingin menggantinya.
            </div>

            <div class="form-group">
                <label for="password">Password Baru (Opsional)</label>
                <input id="password" type="password" name="password"
                       class="bloom-input" minlength="8"
                       autocomplete="new-password" placeholder="Minimal 8 karakter">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password"
                       name="password_confirmation" class="bloom-input"
                       minlength="8" autocomplete="new-password"
                       placeholder="Ulangi password baru">
            </div>

            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="bloom-btn secondary">Batal</a>
                <button type="submit" class="bloom-btn">Simpan Perubahan ↗</button>
            </div>
        </form>
    </section>
</div>

<style>
.user-form-page { --rose:#f0a9b5; --cream:#fff8f3; color:var(--cream); max-width:850px; }
.user-form-page .page-heading { display:flex; justify-content:space-between; align-items:center; gap:15px; flex-wrap:wrap; margin-bottom:25px; }
.user-form-page .eyebrow { color:var(--rose); font-size:10px; font-weight:700; letter-spacing:2px; }
.user-form-page .page-heading h1 { margin:9px 0; font:500 32px 'Playfair Display',serif; }
.user-form-page .page-heading p,.user-form-page .form-title p { margin:0; color:rgba(255,248,243,.7); font-size:12px; }
.user-form-page .glass-panel { padding:28px; border:1px solid rgba(255,255,255,.17); border-radius:16px; background:linear-gradient(135deg,rgba(111,51,76,.82),rgba(42,24,39,.9)); backdrop-filter:blur(16px); }
.user-form-page .form-title { display:flex; gap:13px; align-items:center; padding-bottom:20px; margin-bottom:22px; border-bottom:1px solid rgba(255,255,255,.13); }
.user-form-page .flower-icon { display:grid; place-items:center; width:42px; height:42px; border-radius:12px; background:rgba(240,169,181,.17); color:var(--rose); font-size:23px; }
.user-form-page .form-title h2 { margin:0 0 6px; font:500 23px 'Playfair Display',serif; }
.user-form-page .form-group { margin-bottom:19px; }
.user-form-page .form-group label { display:block; margin-bottom:8px; font-size:12px; font-weight:700; }
.user-form-page .bloom-input { display:block; width:100%; padding:12px 13px; border:1px solid rgba(255,255,255,.2); border-radius:9px; background:rgba(255,255,255,.08); color:var(--cream); font:12px 'DM Sans',sans-serif; outline:none; }
.user-form-page .bloom-input:focus { border-color:var(--rose); }
.user-form-page .bloom-input::placeholder { color:rgba(255,248,243,.48); }
.user-form-page select option { background:#432638; color:white; }
.user-form-page .password-note { padding:12px; margin-bottom:19px; border-radius:8px; background:rgba(240,169,181,.12); color:#ffc7ce; font-size:11px; line-height:1.7; }
.user-form-page .bloom-btn { display:inline-flex; align-items:center; justify-content:center; padding:11px 15px; border:1px solid transparent; border-radius:9px; background:var(--rose); color:#351c2a; font:700 11px 'DM Sans',sans-serif; text-decoration:none; cursor:pointer; }
.user-form-page .bloom-btn.secondary { background:rgba(255,255,255,.08); color:var(--cream); border-color:rgba(255,255,255,.18); }
.user-form-page .form-actions { display:flex; justify-content:flex-end; flex-wrap:wrap; gap:10px; margin-top:25px; padding-top:20px; border-top:1px solid rgba(255,255,255,.13); }
.user-form-page .notice { margin-bottom:18px; padding:12px; border-radius:8px; font-size:12px; }
.user-form-page .notice.error { background:rgba(182,94,88,.2); color:#ffd1cc; }
@media(max-width:600px) { .user-form-page .glass-panel { padding:18px; } .user-form-page .page-heading h1 { font-size:26px; } }
</style>
@endsection