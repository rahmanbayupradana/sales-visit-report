@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit Instansi</h1>
        <p>Perbarui informasi instansi.</p>
    </div>

    <a href="{{ route('institutions.index') }}" class="btn-secondary">
        ← Kembali
    </a>

</div>


<div class="form-card">

    <form
        action="{{ route('institutions.update', $institution) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        {{-- NAMA --}}
        <div class="form-group">

            <label for="name">
                Nama Instansi <span>*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $institution->name) }}"
                required
            >

            @error('name')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- PIC --}}
        <div class="form-group">

            <label for="pic_name">
                Nama PIC
            </label>

            <input
                type="text"
                id="pic_name"
                name="pic_name"
                value="{{ old('pic_name', $institution->pic_name) }}"
            >

            @error('pic_name')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- TELEPON --}}
        <div class="form-group">

            <label for="phone">
                No. Telepon
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone', $institution->phone) }}"
            >

            @error('phone')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- ALAMAT --}}
        <div class="form-group">

            <label for="address">
                Alamat
            </label>

            <textarea
                id="address"
                name="address"
                rows="4"
            >{{ old('address', $institution->address) }}</textarea>

            @error('address')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- PEMILIK --}}
        <div class="owner-info">

            <strong>Sales:</strong>

            {{ $institution->user->name ?? 'Belum ditentukan' }}

        </div>


        <div class="form-actions">

            <a
                href="{{ route('institutions.index') }}"
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
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    max-width: 800px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.form-group label span {
    color: #dc2626;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 11px 13px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 14px;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #2563eb;
}

.form-group textarea {
    resize: vertical;
}

.error-message {
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
}

.owner-info {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1e40af;
    padding: 13px 15px;
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