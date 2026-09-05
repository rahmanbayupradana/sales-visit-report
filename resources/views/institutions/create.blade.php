@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah Instansi</h1>
        <p>Tambahkan data instansi baru.</p>
    </div>

    <a href="{{ route('institutions.index') }}" class="btn-secondary">
        ← Kembali
    </a>

</div>


<div class="form-card">

    <form
        action="{{ route('institutions.store') }}"
        method="POST"
    >

        @csrf


        {{-- NAMA INSTANSI --}}
        <div class="form-group">

            <label for="name">
                Nama Instansi <span>*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contoh: PT Maju Jaya"
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
                value="{{ old('pic_name') }}"
                placeholder="Contoh: Budi Santoso"
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
                value="{{ old('phone') }}"
                placeholder="Contoh: 08123456789"
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
                placeholder="Masukkan alamat lengkap instansi..."
            >{{ old('address') }}</textarea>

            @error('address')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- INFO SALES --}}
        <div class="owner-info">

            <strong>Sales:</strong>

            {{ auth()->user()->name }}

        </div>


        {{-- BUTTON --}}
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
                💾 Simpan Instansi
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
    color: #374151;
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
    text-decoration: none;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

.btn-primary:hover {
    background: #1d4ed8;
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

@media (max-width: 768px) {

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .form-actions {
        flex-direction: column;
    }

}

</style>

@endsection