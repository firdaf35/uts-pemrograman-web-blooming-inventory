@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('breadcrumb', 'Manajemen Pengguna')

@section('content')
<div class="users-page">
    <div class="page-heading">
        <div>
            <span class="eyebrow">BLOOMING · TEAM MANAGEMENT</span>
            <h1>Manajemen Pengguna ✿</h1>
            <p>Kelola akun dan akses pengguna sistem Blooming.</p>
        </div>

        <a href="{{ route('users.create') }}" class="bloom-btn">
            + Tambah Pengguna
        </a>
    </div>

    <div class="summary-grid">
        <div class="glass-card">
            <span>Total Pengguna</span>
            <strong>{{ $users->total() }}</strong>
            <small>Semua akun terdaftar</small>
        </div>

        <div class="glass-card">
            <span>Admin</span>
            <strong>{{ \App\Models\User::where('role', 'admin')->count() }}</strong>
            <small>Akses pengelolaan sistem</small>
        </div>

        <div class="glass-card">
            <span>Staff</span>
            <strong>{{ \App\Models\User::where('role', 'staff')->count() }}</strong>
            <small>Akses operasional</small>
        </div>
    </div>

    <section class="glass-panel">
        <div class="panel-heading">
            <div>
                <h2>Daftar Pengguna</h2>
                <p>Cari akun berdasarkan nama, email, atau role.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('users.index') }}" class="filter-form">
            <input
                type="text"
                name="search"
                class="bloom-input"
                placeholder="Cari nama atau email..."
                value="{{ request('search') }}"
            >

            <select name="role" class="bloom-input">
                <option value="">Semua Role</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="staff" @selected(request('role') === 'staff')>Staff</option>
            </select>

            <button type="submit" class="bloom-btn">Cari</button>
            <a href="{{ route('users.index') }}" class="bloom-btn secondary">Reset</a>
        </form>

        @if ($errors->any())
            <div class="notice error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="person-cell">
                                    <span class="person-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        @if ($user->id === auth()->id())
                                            <small>Akun kamu</small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>{{ $user->email }}</td>

                            <td>
                                <span class="role-badge {{ $user->role === 'admin' ? 'role-admin' : 'role-staff' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td>{{ $user->created_at?->format('d/m/Y') ?? '—' }}</td>

                            <td>
                                <div class="action-group">
                                    <a href="{{ route('users.edit', $user) }}" class="action-btn">
                                        Edit
                                    </a>

                                    @if ($user->id !== auth()->id())
                                        <form
                                            action="{{ route('users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus akun {{ addslashes($user->name) }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-cell">
                                <span>✿</span>
                                <strong>Pengguna belum ditemukan</strong>
                                <p>Coba kata kunci lain atau tambahkan akun baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $users->links() }}</div>
    </section>
</div>

<style>
.users-page {
    --wine: #572b3b;
    --rose: #f0a9b5;
    --cream: #fff8f3;
    color: var(--cream);
}
.users-page .eyebrow {
    color: #f0a9b5;
    font-size: 10px;
    letter-spacing: 2px;
    font-weight: 700;
}
.users-page .page-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}
.users-page .page-heading h1 {
    margin: 9px 0;
    font: 500 32px 'Playfair Display', serif;
    color: var(--cream);
}
.users-page .page-heading p,
.users-page .panel-heading p {
    color: rgba(255,248,243,.7);
    font-size: 12px;
    margin: 0;
}
.users-page .bloom-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 11px 15px;
    border: 1px solid transparent;
    border-radius: 9px;
    background: var(--rose);
    color: #351c2a;
    font: 700 11px 'DM Sans', sans-serif;
    cursor: pointer;
    text-decoration: none;
}
.users-page .bloom-btn:hover { background: #ffc7ce; }
.users-page .bloom-btn.secondary {
    background: rgba(255,255,255,.08);
    color: var(--cream);
    border-color: rgba(255,255,255,.17);
}
.users-page .summary-grid {
    display: grid;
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 15px;
    margin-bottom: 22px;
}
.users-page .glass-card,
.users-page .glass-panel {
    background: linear-gradient(135deg,rgba(111,51,76,.78),rgba(42,24,39,.86));
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 15px;
    box-shadow: 0 12px 30px rgba(15,5,12,.12);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}
.users-page .glass-card { padding: 20px; }
.users-page .glass-card span,
.users-page .glass-card small { display: block; color: rgba(255,248,243,.75); font-size: 11px; }
.users-page .glass-card strong {
    display: block;
    margin: 13px 0 7px;
    color: var(--cream);
    font: 500 30px 'Playfair Display',serif;
}
.users-page .glass-panel { padding: 22px; }
.users-page .panel-heading { margin-bottom: 18px; }
.users-page .panel-heading h2 {
    margin: 0 0 7px;
    color: var(--cream);
    font: 500 23px 'Playfair Display',serif;
}
.users-page .filter-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.users-page .bloom-input {
    min-width: 150px;
    flex: 1;
    padding: 11px 12px;
    color: var(--cream);
    background: rgba(255,255,255,.09);
    border: 1px solid rgba(255,255,255,.19);
    border-radius: 9px;
    font: 12px 'DM Sans',sans-serif;
    outline: none;
}
.users-page .bloom-input:focus { border-color: var(--rose); }
.users-page .bloom-input::placeholder { color: rgba(255,248,243,.55); }
.users-page select.bloom-input option { background: #432638; color: white; }
.users-page .table-wrap { overflow-x: auto; }
.users-page .users-table { width: 100%; min-width: 700px; border-collapse: collapse; color: var(--cream); font-size: 12px; }
.users-page .users-table th {
    padding: 13px 11px;
    background: rgba(255,255,255,.08);
    color: rgba(255,248,243,.75);
    text-align: left;
    font-size: 10px;
    letter-spacing: .5px;
}
.users-page .users-table td {
    padding: 14px 11px;
    border-bottom: 1px solid rgba(255,255,255,.11);
}
.users-page .person-cell { display: flex; align-items: center; gap: 10px; }
.users-page .person-avatar {
    width: 35px; height: 35px; flex-shrink: 0;
    display: grid; place-items: center;
    border-radius: 11px; background: rgba(240,169,181,.2); color: var(--rose);
    font: 500 17px 'Playfair Display',serif;
}
.users-page .person-cell strong { display: block; }
.users-page .person-cell small { display: block; margin-top: 4px; color: var(--rose); font-size: 10px; }
.users-page .role-badge { padding: 6px 9px; border-radius: 7px; font-size: 10px; }
.users-page .role-admin { background: rgba(240,169,181,.18); color: #ffc7ce; }
.users-page .role-staff { background: rgba(165,203,154,.16); color: #c5e8bd; }
.users-page .action-group { display: flex; gap: 7px; align-items: center; }
.users-page .action-btn {
    padding: 7px 10px; border: 1px solid rgba(255,255,255,.2);
    border-radius: 7px; background: rgba(255,255,255,.08);
    color: var(--cream); font: 10px 'DM Sans',sans-serif;
    cursor: pointer; text-decoration: none;
}
.users-page .delete-btn { color: #ffc7ce; border-color: rgba(240,169,181,.3); }
.users-page .empty-cell { padding: 35px; text-align: center; }
.users-page .empty-cell span { display: block; font-size: 25px; color: var(--rose); }
.users-page .empty-cell strong { display: block; margin-top: 10px; }
.users-page .empty-cell p { color: rgba(255,248,243,.65); }
.users-page .pagination { margin-top: 20px; }
.users-page .pagination nav p { color: var(--cream); }
.users-page .notice { margin-bottom: 15px; padding: 12px; border-radius: 8px; font-size: 12px; }
.users-page .notice.error { background: rgba(182,94,88,.2); color: #ffd1cc; }
@media(max-width:700px) {
    .users-page .summary-grid { grid-template-columns: 1fr; }
    .users-page .glass-panel { padding: 14px; }
    .users-page .page-heading h1 { font-size: 26px; }
}
</style>
@endsection