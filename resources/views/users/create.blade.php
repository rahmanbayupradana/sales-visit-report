@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah User</h1>
        <p>Tambahkan Admin atau Sales baru.</p>
    </div>

    <a
        href="{{ route('users.index') }}"
        class="btn-secondary"
    >
        ← Kembali
    </a>

</div>


<div class="form-card">

    <form
        action="{{ route('users.store') }}"
        method="POST"
    >

        @csrf


        <div class="form-group">

            <label>
                Nama
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
            >

            @error('name')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="form-group">

            <label>
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >

            @error('email')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="form-group">

            <label>
                Role
            </label>

            <select name="role" required>

                <option value="">
                    -- Pilih Role --
                </option>

                <option
                    value="sales"
                    {{ old('role') === 'sales' ? 'selected' : '' }}
                >
                    Sales
                </option>

                <option
                    value="admin"
                    {{ old('role') === 'admin' ? 'selected' : '' }}
                >
                    Admin
                </option>

            </select>

            @error('role')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="form-group">

            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                required
            >

            <small>
                Minimal 6 karakter.
            </small>

            @error('password')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="form-group">

            <label>
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                required
            >

        </div>


        <div class="form-actions">

            <a
                href="{{ route('users.index') }}"
                class="btn-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn-primary"
            >
                💾 Simpan User
            </button>

        </div>

    </form>

</div>


<style>

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-header h1 {
    margin: 0 0 5px;
}

.page-header p {
    margin: 0;
    color: #6b7280;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    max-width: 700px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.form-group input,
.form-group select {
    width: 100%;
    box-sizing: border-box;
    padding: 11px 13px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
}

.form-group small {
    display: block;
    margin-top: 5px;
    color: #6b7280;
}

.error-message {
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-primary {
    padding: 11px 18px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

.btn-secondary {
    display: inline-block;
    padding: 11px 18px;
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
}

</style>

@endsection