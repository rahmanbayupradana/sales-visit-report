@extends('layouts.app')

@section('title', 'Laporan Kunjungan')

@section('breadcrumb', 'Laporan Kunjungan')

@section('content')

<div class="page-header">

    <div class="page-header">

    <div>
        <h1 class="page-title">
            Laporan Kunjungan
        </h1>

        <p class="page-subtitle">
            Data aktivitas kunjungan sales.
        </p>
    </div>


    <div class="header-actions">

        <a
            href="{{ route('visits.export.excel', request()->query()) }}"
            class="btn-export excel"
        >
            📊 Export Excel
        </a>

        <a
            href="{{ route('visits.export.pdf', request()->query()) }}"
            class="btn-export pdf"
        >
            📄 Export PDF
        </a>

        <a
            href="{{ route('visits.create') }}"
            class="btn-primary"
        >
            ＋ Tambah Laporan
        </a>

    </div>

</div>

</div>

{{-- FILTER --}}

<div class="panel">

    <div style="padding: 20px;">

        <form
            method="GET"
            action="{{ route('visits.index') }}"
        >

            <div class="filter-card">

    <form
        method="GET"
        action="{{ route('visits.index') }}"
    >

        <div class="filter-grid">

            {{-- SEARCH --}}
            <div class="filter-item">

                <label>
                    Cari
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama instansi / PIC"
                >

            </div>


            {{-- SALES --}}
            @if(auth()->user()->role === 'admin')

                <div class="filter-item">

                    <label>
                        Sales
                    </label>

                    <select name="sales_id">

                        <option value="">
                            Semua Sales
                        </option>

                        @foreach($sales as $sale)

                            <option
                                value="{{ $sale->id }}"
                                {{ request('sales_id') == $sale->id ? 'selected' : '' }}
                            >
                                {{ $sale->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            @endif


            {{-- INSTANSI --}}
            <div class="filter-item">

                <label>
                    Instansi
                </label>

                <select name="institution_id">

                    <option value="">
                        Semua Instansi
                    </option>

                    @foreach($institutions as $institution)

                        <option
                            value="{{ $institution->id }}"
                            {{ request('institution_id') == $institution->id ? 'selected' : '' }}
                        >
                            {{ $institution->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- JENIS --}}
            <div class="filter-item">

                <label>
                    Jenis Kunjungan
                </label>

                <select name="visit_type_id">

                    <option value="">
                        Semua Jenis
                    </option>

                    @foreach($visitTypes as $type)

                        <option
                            value="{{ $type->id }}"
                            {{ request('visit_type_id') == $type->id ? 'selected' : '' }}
                        >
                            {{ $type->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- HASIL --}}
            <div class="filter-item">

                <label>
                    Hasil Kunjungan
                </label>

                <select name="visit_result_id">

                    <option value="">
                        Semua Hasil
                    </option>

                    @foreach($visitResults as $result)

                        <option
                            value="{{ $result->id }}"
                            {{ request('visit_result_id') == $result->id ? 'selected' : '' }}
                        >
                            {{ $result->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- TANGGAL MULAI --}}
            <div class="filter-item">

                <label>
                    Dari Tanggal
                </label>

                <input
                    type="date"
                    name="date_from"
                    value="{{ request('date_from') }}"
                >

            </div>


            {{-- TANGGAL AKHIR --}}
            <div class="filter-item">

                <label>
                    Sampai Tanggal
                </label>

                <input
                    type="date"
                    name="date_to"
                    value="{{ request('date_to') }}"
                >

            </div>


        </div>


        <div class="filter-actions">

            <button
                type="submit"
                class="btn-primary"
            >
                🔍 Terapkan Filter
            </button>

            <a
                href="{{ route('visits.index') }}"
                class="btn-secondary"
            >
                Reset
            </a>

        </div>

    </form>

</div>

        </form>

    </div>


    {{-- TABLE --}}

    <div class="table-wrapper">

        <table class="visit-table">

           <thead>

    <tr>

        <th>No</th>

        <th>Tanggal</th>

        @if(auth()->user()->role === 'admin')
            <th>Sales</th>
        @endif

        <th>Instansi</th>

        <th>PIC</th>

        <th>Jenis</th>

        <th>Hasil</th>

        <th>Aksi</th>

    </tr>

</thead>


            <tbody>

    @forelse($visits as $visit)

        <tr>

            <td>
                {{ $loop->iteration + ($visits->currentPage() - 1) * $visits->perPage() }}
            </td>


            <td>

                <strong>
                    {{ $visit->visit_date->format('d/m/Y') }}
                </strong>

                <br>

                <small>
                    {{ $visit->visit_time }}
                </small>

            </td>


            @if(auth()->user()->role === 'admin')

                <td>
                    {{ $visit->sales->name ?? '-' }}
                </td>

            @endif


            <td>
                {{ $visit->institution->name ?? '-' }}
            </td>


            <td>
                {{ $visit->institution->pic_name ?? '-' }}
            </td>


            <td>
                {{ $visit->type->name ?? '-' }}
            </td>


            <td>

                @php
                    $resultName = strtolower(
                        $visit->result->name ?? ''
                    );
                @endphp

                @if(str_contains($resultName, 'berhasil'))

                    <span class="badge-success">
                        {{ $visit->result->name }}
                    </span>

                @elseif(str_contains($resultName, 'pending'))

                    <span class="badge-warning">
                        {{ $visit->result->name }}
                    </span>

                @else

                    <span class="result-badge">
                        {{ $visit->result->name ?? '-' }}
                    </span>
                     <span style="color:#9ca3af;">
            -
                    </span>
                @endif

            </td>


            <td>

                <div class="action-buttons">

                    <a
                        href="{{ route('visits.show', $visit) }}"
                        class="btn-view"
                        title="Detail"
                    >
                        👁
                    </a>


                    <a
                        href="{{ route('visits.edit', $visit) }}"
                        class="btn-edit"
                        title="Edit"
                    >
                        ✏️
                    </a>


                    @if(auth()->user()->role === 'admin')

                        <form
                            action="{{ route('visits.destroy', $visit) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-delete"
                                title="Hapus"
                            >
                                🗑
                            </button>

                        </form>

                    @endif

                </div>

            </td>

        </tr>

    @empty

        <tr>

            <td
                colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}"
                class="empty-data"
            >

                Belum ada laporan kunjungan.

            </td>

        </tr>

    @endforelse

</tbody>

        </table>

    </div>


    {{-- PAGINATION --}}

    @if($visits->hasPages())

        <div class="pagination-wrapper">

            {{ $visits->links() }}

        </div>

    @endif

</div>


<style>

    .filter-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.filter-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-item label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.filter-item input,
.filter-item select {
    width: 100%;
    box-sizing: border-box;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: white;
}

.filter-item input:focus,
.filter-item select:focus {
    outline: none;
    border-color: #2563eb;
}

.filter-actions {
    display: flex;
    gap: 10px;
    margin-top: 18px;
}

@media (max-width: 1000px) {

    .filter-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 650px) {

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .filter-actions {
        flex-direction: column;
    }

}

    .filter-grid {

        display: grid;

        grid-template-columns:
            2fr
            1fr
            1fr
            1fr
            1fr
            auto;

        gap: 12px;

        align-items: end;
    }

    .filter-grid label {

        display: block;

        font-size: 12px;

        color: #6b7280;

        margin-bottom: 7px;
    }

    .form-input {

        width: 100%;

        padding: 10px 12px;

        border:
            1px solid #d1d5db;

        border-radius: 7px;

        background: white;

        font-size: 13px;
    }

    .form-input:focus {

        outline: none;

        border-color: #6b7280;
    }

    .filter-button {

        display: flex;

        gap: 6px;
    }

    .btn-reset {

        background: #f3f4f6;

        color: #374151;
    }

    .table-wrapper {

        overflow-x: auto;

        border-top:
            1px solid #e5e7eb;
    }

    .visit-table {

        width: 100%;

        border-collapse: collapse;

        min-width: 1050px;
    }

    .visit-table th {

        text-align: left;

        padding:
            14px 16px;

        background: #fafafa;

        color: #6b7280;

        font-size: 11px;

        font-weight: 600;

        border-bottom:
            1px solid #e5e7eb;
    }

    .visit-table td {

        padding:
            15px 16px;

        border-bottom:
            1px solid #f0f0f0;

        font-size: 13px;

        vertical-align: middle;
    }

    .visit-table tbody tr:hover {

        background: #fafafa;
    }

    .muted {

        color: #9ca3af;

        font-size: 11px;
    }

    .type-badge {

        display: inline-block;

        padding:
            5px 9px;

        background: #f3f4f6;

        color: #4b5563;

        border-radius: 20px;

        font-size: 11px;
    }

    .result-badge {

        display: inline-block;

        padding:
            6px 10px;

        border-radius: 20px;

        font-size: 10px;

        font-weight: 600;
    }

    .result-default {

        background: #fffbeb;

        color: #a16207;

        border:
            1px solid #fde68a;
    }

    .result-warning {

        background: #fff7ed;

        color: #c2410c;

        border:
            1px solid #fed7aa;
    }

    .result-success {

        background: #ecfdf5;

        color: #047857;

        border:
            1px solid #a7f3d0;
    }

    .result-danger {

        background: #fef2f2;

        color: #b91c1c;

        border:
            1px solid #fecaca;
    }

    .action-buttons {

        display: flex;

        align-items: center;

        gap: 6px;
    }

    .action-buttons a,
    .action-buttons button {

        border: none;

        background: transparent;

        cursor: pointer;

        font-size: 11px;

        text-decoration: none;

    }

    .action-view {

        color: #374151;
    }

    .action-edit {

        color: #2563eb;
    }

    .action-delete {

        color: #dc2626;
    }

    .empty {

        text-align: center;

        padding: 50px !important;

        color: #9ca3af;
    }

    .pagination {

        padding: 20px;

        display: flex;

        justify-content: center;
    }

    @media (max-width: 1100px) {

        .filter-grid {

            grid-template-columns:
                repeat(2, 1fr);
        }

    }

    .badge-success {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    background: #dcfce7;
    color: #166534;
    font-size: 12px;
    font-weight: 600;
}

.badge-warning {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    background: #fef3c7;
    color: #92400e;
    font-size: 12px;
    font-weight: 600;
}

.badge-info {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    background: #dbeafe;
    color: #1e40af;
    font-size: 12px;
    font-weight: 600;
}

.header-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.btn-export {
    display: inline-block;
    padding: 11px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.btn-export.excel {
    background: #dcfce7;
    color: #166534;
}

.btn-export.pdf {
    background: #fee2e2;
    color: #991b1b;
}

.btn-export:hover {
    opacity: 0.85;
}

/* ========================================
   HEADER
======================================== */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 24px;
}

.page-title {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #111827;
}

.page-subtitle {
    margin: 6px 0 0;
    color: #6b7280;
    font-size: 14px;
}


/* ========================================
   BUTTON
======================================== */

.header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-primary,
.btn-secondary,
.btn-export {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 40px;
    padding: 0 15px;

    border-radius: 8px;

    font-size: 14px;
    font-weight: 600;

    text-decoration: none;

    border: none;
    cursor: pointer;

    box-sizing: border-box;

    transition: all .15s ease;
}

.btn-primary {
    background: #111827;
    color: white !important;
}

.btn-primary:hover {
    background: #1f2937;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151 !important;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.btn-export.excel {
    background: #dcfce7;
    color: #166534 !important;
}

.btn-export.excel:hover {
    background: #bbf7d0;
}

.btn-export.pdf {
    background: #fee2e2;
    color: #991b1b !important;
}

.btn-export.pdf:hover {
    background: #fecaca;
}


/* ========================================
   FILTER
======================================== */

.filter-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.filter-grid {
    display: grid;
    grid-template-columns:
        1.5fr
        1fr
        1fr
        1fr
        1fr
        1fr;

    gap: 14px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: #4b5563;
}

.filter-group input,
.filter-group select {
    width: 100%;
    height: 40px;

    padding: 0 11px;

    border: 1px solid #d1d5db;
    border-radius: 8px;

    background: white;

    color: #111827;

    font-size: 13px;

    outline: none;

    box-sizing: border-box;
}

.filter-group input:focus,
.filter-group select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

.filter-actions {
    display: flex;
    gap: 10px;
    margin-top: 16px;
}


/* ========================================
   TABLE
======================================== */

.table-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.table-wrapper {
    overflow-x: auto;
}

.visit-table {
    width: 100%;
    border-collapse: collapse;
}

.visit-table th {
    background: #f9fafb;
    color: #6b7280;

    font-size: 11px;
    font-weight: 700;

    text-transform: uppercase;

    padding: 13px 14px;

    text-align: left;

    border-bottom: 1px solid #e5e7eb;

    white-space: nowrap;
}

.visit-table td {
    padding: 14px;

    color: #374151;

    font-size: 13px;

    border-bottom: 1px solid #f3f4f6;

    vertical-align: middle;
}

.visit-table tbody tr:hover {
    background: #f9fafb;
}

.visit-table tbody tr:last-child td {
    border-bottom: none;
}


/* ========================================
   RESULT BADGE
======================================== */

.result-badge {
    display: inline-flex;

    padding: 5px 9px;

    border-radius: 999px;

    background: #eff6ff;
    color: #1d4ed8;

    font-size: 11px;
    font-weight: 700;

    white-space: nowrap;
}


/* ========================================
   ACTION
======================================== */

.action-buttons {
    display: flex;
    align-items: center;
    gap: 6px;
}

.action-btn {
    width: 32px;
    height: 32px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    text-decoration: none;

    font-size: 14px;

    border: none;

    cursor: pointer;
}

.action-view {
    background: #eff6ff;
    color: #2563eb;
}

.action-edit {
    background: #fef3c7;
    color: #92400e;
}

.action-delete {
    background: #fee2e2;
    color: #dc2626;
}

.action-btn:hover {
    transform: translateY(-1px);
}


/* ========================================
   PAGINATION
======================================== */

.pagination-wrapper {
    padding: 16px;
    border-top: 1px solid #f3f4f6;
}


/* ========================================
   RESPONSIVE
======================================== */

@media (max-width: 1100px) {

    .filter-grid {
        grid-template-columns:
            repeat(3, 1fr);
    }

}

@media (max-width: 700px) {

    .page-header {
        flex-direction: column;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .header-actions {
        width: 100%;
    }

    .btn-primary,
    .btn-secondary,
    .btn-export {
        flex: 1;
    }

}

</style>

@endsection