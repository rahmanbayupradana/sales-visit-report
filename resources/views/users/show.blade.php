@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <h1>Detail User</h1>
        <p>Informasi user aplikasi.</p>
    </div>

    <a
        href="{{ route('users.index') }}"
        class="btn-secondary"
    >
        ← Kembali
    </a>

</div>


<div class="detail-card">

    <h2>{{ $user->name }}</h2>

    <div class="detail-grid">

        <div>
            <span>Nama</span>
            <strong>{{ $user->name }}</strong>
        </div>

        <div>
            <span>Email</span>
            <strong>{{ $user->email }}</strong>
        </div>

        <div>
            <span>Role</span>
            <strong>{{ strtoupper($user->role) }}</strong>
        </div>

        <div>
            <span>Status</span>

            <strong>
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
            </strong>

        </div>

    </div>


    <hr>


    <h3>Reset Password</h3>

    <form
        action="{{ route('users.reset-password', $user) }}"
        method="POST"
    >

        @csrf

        <div class="form-group">

            <label>Password Baru</label>

            <input
                type="password"
                name="password"
                required
            >

        </div>


        <div class="form-group">

            <label>Konfirmasi Password</label>

            <input
                type="password"
                name="password_confirmation"
                required
            >

        </div>


        <button
            type="submit"
            class="btn-primary"
        >
            🔑 Reset Password
        </button>

    </form>

</div>


<style>

.page-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
}

.detail-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    max-width: 800px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 25px 0;
}

.detail-grid div {
    background: #f9fafb;
    padding: 15px;
    border-radius: 8px;
}

.detail-grid span {
    display: block;
    color: #6b7280;
    font-size: 13px;
    margin-bottom: 5px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 7px;
    font-weight: 600;
}

.form-group input {
    width: 100%;
    box-sizing: border-box;
    padding: 11px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
}

.btn-primary {
    padding: 11px 18px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.btn-secondary {
    display: inline-block;
    padding: 11px 18px;
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 8px;
}

@media(max-width:768px) {

    .detail-grid {
        grid-template-columns: 1fr;
    }

}

</style>

@endsection