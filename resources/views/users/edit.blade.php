@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit User</h1>
        <p>Perbarui informasi user.</p>
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
        action="{{ route('users.update', $user) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        <div class="form-group">

            <label>
                Nama
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
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
                value="{{ old('email', $user->email) }}"
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

                <option
                    value="sales"
                    {{ $user->role === 'sales' ? 'selected' : '' }}
                >
                    Sales
                </option>

                <option
                    value="admin"
                    {{ $user->role === 'admin' ? 'selected' : '' }}
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


        <div class="user-info">

            Status saat ini:

            @if($user->is_active)
                <strong>Aktif</strong>
            @else
                <strong>Nonaktif</strong>
            @endif

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
                💾 Simpan Perubahan
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

.form-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    max-width: 700px;
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

.error-message {
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
}

.user-info {
    padding: 13px;
    background: #f3f4f6;
    border-radius: 8px;
    margin-bottom: 25px;
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
}

.btn-secondary {
    display: inline-block;
    padding: 11px 18px;
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 8px;
}

</style>

@endsection