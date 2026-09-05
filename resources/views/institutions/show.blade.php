@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <h1>Detail Instansi</h1>
        <p>Informasi lengkap instansi.</p>
    </div>

    <a
        href="{{ route('institutions.index') }}"
        class="btn-secondary"
    >
        ← Kembali
    </a>

</div>


<div class="detail-card">

    <div class="detail-header">

        <div class="institution-icon">
            🏢
        </div>

        <div>

            <h2>
                {{ $institution->name }}
            </h2>

            <p>
                Instansi
            </p>

        </div>

    </div>


    <div class="detail-grid">


        <div class="detail-item">

            <span class="label">
                Nama Instansi
            </span>

            <strong>
                {{ $institution->name }}
            </strong>

        </div>


        <div class="detail-item">

            <span class="label">
                PIC
            </span>

            <strong>
                {{ $institution->pic_name ?? '-' }}
            </strong>

        </div>


        <div class="detail-item">

            <span class="label">
                No. Telepon
            </span>

            <strong>
                {{ $institution->phone ?? '-' }}
            </strong>

        </div>


        <div class="detail-item">

            <span class="label">
                Sales
            </span>

            <strong>
                {{ $institution->user->name ?? '-' }}
            </strong>

        </div>


        <div class="detail-item full">

            <span class="label">
                Alamat
            </span>

            <strong>
                {{ $institution->address ?? '-' }}
            </strong>

        </div>


        <div class="detail-item">

            <span class="label">
                Dibuat
            </span>

            <strong>
                {{ $institution->created_at?->format('d/m/Y H:i') }}
            </strong>

        </div>


        <div class="detail-item">

            <span class="label">
                Terakhir diperbarui
            </span>

            <strong>
                {{ $institution->updated_at?->format('d/m/Y H:i') }}
            </strong>

        </div>


    </div>


    <div class="detail-actions">

        <a
            href="{{ route('institutions.edit', $institution) }}"
            class="btn-primary"
        >
            ✏️ Edit Instansi
        </a>

        @if(auth()->user()->role === 'admin')

            <form
                action="{{ route('institutions.destroy', $institution) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus instansi ini?')"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn-danger"
                >
                    🗑 Hapus Instansi
                </button>

            </form>

        @endif

    </div>

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

.detail-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    max-width: 900px;
}

.detail-header {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-bottom: 25px;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 25px;
}

.institution-icon {
    width: 55px;
    height: 55px;
    background: #eff6ff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.detail-header h2 {
    margin: 0 0 4px;
}

.detail-header p {
    margin: 0;
    color: #6b7280;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 15px;
    background: #f9fafb;
    border-radius: 8px;
}

.detail-item.full {
    grid-column: span 2;
}

.label {
    color: #6b7280;
    font-size: 13px;
}

.detail-actions {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.btn-primary {
    display: inline-block;
    padding: 11px 18px;
    background: #2563eb;
    color: white;
    text-decoration: none;
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

.btn-danger {
    padding: 11px 18px;
    background: #dc2626;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

@media (max-width: 768px) {

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }

    .detail-item.full {
        grid-column: span 1;
    }

    .detail-actions {
        flex-direction: column;
    }

}

</style>

@endsection