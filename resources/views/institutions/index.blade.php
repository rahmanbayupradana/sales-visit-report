@extends('layouts.app')

@section('title', 'Instansi')

@section('content')

<style>

    .pagination-wrapper {
    padding: 16px 20px;

    border-top: 1px solid #f3f4f6;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    flex-wrap: wrap;
}

.pagination-custom {
    display: flex;

    align-items: center;

    gap: 5px;
}

.pagination-button,
.pagination-active,
.pagination-disabled {
    min-width: 34px;

    height: 34px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 7px;

    font-size: 13px;

    font-weight: 600;

    text-decoration: none;

    box-sizing: border-box;
}

.pagination-button {
    border: 1px solid #e5e7eb;

    background: white;

    color: #374151;
}

.pagination-button:hover {
    background: #f3f4f6;
}

.pagination-active {
    background: #111827;

    color: white;
}

.pagination-disabled {
    border: 1px solid #f3f4f6;

    background: #f9fafb;

    color: #d1d5db;
}

.pagination-info {
    color: #6b7280;

    font-size: 12px;
}

.pagination-info strong {
    color: #374151;
}

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

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-secondary {
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
    }

    .btn-primary {
        background: #111827;
        color: white !important;
    }

    .btn-primary:hover {
        background: #1f2937;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151 !important;
    }

    .search-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .search-form {
        display: flex;
        gap: 10px;
        align-items: end;
        flex-wrap: wrap;
    }

    .search-group {
        flex: 1;
        min-width: 250px;
    }

    .search-group label {
        display: block;
        margin-bottom: 6px;

        font-size: 12px;
        font-weight: 600;

        color: #4b5563;
    }

    .search-group input {
        width: 100%;
        height: 40px;

        box-sizing: border-box;

        padding: 0 12px;

        border: 1px solid #d1d5db;
        border-radius: 8px;

        font-size: 13px;

        outline: none;
    }

    .search-group input:focus {
        border-color: #2563eb;

        box-shadow:
            0 0 0 3px rgba(37, 99, 235, .08);
    }

    .table-card {
        background: white;

        border: 1px solid #e5e7eb;

        border-radius: 12px;

        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .institution-table {
        width: 100%;

        border-collapse: collapse;
    }

    .institution-table th {
        background: #f9fafb;

        color: #6b7280;

        font-size: 11px;

        font-weight: 700;

        text-transform: uppercase;

        padding: 13px 14px;

        text-align: left;

        border-bottom:
            1px solid #e5e7eb;

        white-space: nowrap;
    }

    .institution-table td {
        padding: 14px;

        color: #374151;

        font-size: 13px;

        border-bottom:
            1px solid #f3f4f6;

        vertical-align: middle;
    }

    .institution-table tbody tr:hover {
        background: #f9fafb;
    }

    .institution-table tbody tr:last-child td {
        border-bottom: none;
    }

    .institution-name {
        font-weight: 600;
        color: #111827;
    }

    .institution-phone {
        white-space: nowrap;
    }

    .address {
        max-width: 280px;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;
    }

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

        border: none;

        text-decoration: none;

        cursor: pointer;

        font-size: 14px;
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

    .pagination-wrapper {
        padding: 16px;

        border-top:
            1px solid #f3f4f6;
    }

    .empty-state {
        text-align: center;

        padding: 40px;

        color: #9ca3af;

        font-size: 13px;
    }

    @media (max-width: 700px) {

        .page-header {
            flex-direction: column;
        }

        .header-actions {
            width: 100%;
        }

        .search-form {
            flex-direction: column;
            align-items: stretch;
        }

        .search-group {
            min-width: 0;
        }

    }

</style>


{{-- HEADER --}}

<div class="page-header">

    <div>

        <h1 class="page-title">
            Instansi
        </h1>

        <p class="page-subtitle">
            Data perusahaan dan instansi yang dikunjungi sales.
        </p>

    </div>


    <div class="header-actions">

        <a
            href="{{ route('institutions.create') }}"
            class="btn-primary"
        >
            ＋ Tambah Instansi
        </a>

    </div>

</div>


{{-- SEARCH --}}

<div class="search-card">

    <form
        method="GET"
        action="{{ route('institutions.index') }}"
        class="search-form"
    >

        <div class="search-group">

            <label>
                Cari Instansi
            </label>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nama instansi / PIC"
            >

        </div>


        <button
            type="submit"
            class="btn-primary"
        >
            🔍 Cari
        </button>


        <a
            href="{{ route('institutions.index') }}"
            class="btn-secondary"
        >
            Reset
        </a>

    </form>

</div>


{{-- TABLE --}}

<div class="table-card">

    <div class="table-wrapper">

        <table class="institution-table">

            <thead>

                <tr>

                    <th width="5%">
                        No
                    </th>

                    <th>
                        Instansi
                    </th>

                    <th>
                        PIC
                    </th>

                    <th>
                        Telepon
                    </th>

                    <th>
                        Alamat
                    </th>

                    <th width="120">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($institutions as $institution)

                    <tr>

                        <td>
                            {{ $institutions->firstItem() + $loop->index }}
                        </td>


                        <td>

                            <div class="institution-name">

                                {{ $institution->name }}

                            </div>

                        </td>


                        <td>

                            {{ $institution->pic_name ?? '-' }}

                        </td>


                        <td class="institution-phone">

                            {{ $institution->phone ?? '-' }}

                        </td>


                        <td>

                            <div class="address">

                                {{ $institution->address ?? '-' }}

                            </div>

                        </td>


                        <td>

                            <div class="action-buttons">


                                <a
                                    href="{{ route(
                                        'institutions.show',
                                        $institution->id
                                    ) }}"
                                    class="action-btn action-view"
                                    title="Detail"
                                >
                                    👁
                                </a>


                                <a
                                    href="{{ route(
                                        'institutions.edit',
                                        $institution->id
                                    ) }}"
                                    class="action-btn action-edit"
                                    title="Edit"
                                >
                                    ✏
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'institutions.destroy',
                                        $institution->id
                                    ) }}"
                                    onsubmit="
                                        return confirm(
                                            'Hapus instansi ini?'
                                        )
                                    "
                                    style="display:inline;"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-btn action-delete"
                                        title="Hapus"
                                    >
                                        🗑
                                    </button>

                                </form>


                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="empty-state"
                        >
                            Belum ada data instansi.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="pagination-custom">

    @if ($institutions->onFirstPage())

        <span class="pagination-disabled">
            ‹
        </span>

    @else

        <a
            href="{{ $institutions->previousPageUrl() }}"
            class="pagination-button"
        >
            ‹
        </a>

    @endif


    @foreach ($institutions->getUrlRange(1, $institutions->lastPage()) as $page => $url)

        @if ($page == $institutions->currentPage())

            <span class="pagination-active">
                {{ $page }}
            </span>

        @else

            <a
                href="{{ $url }}"
                class="pagination-button"
            >
                {{ $page }}
            </a>

        @endif

    @endforeach


    @if ($institutions->hasMorePages())

        <a
            href="{{ $institutions->nextPageUrl() }}"
            class="pagination-button"
        >
            ›
        </a>

    @else

        <span class="pagination-disabled">
            ›
        </span>

    @endif

</div>


<div class="pagination-info">

    Menampilkan
    <strong>{{ $institutions->firstItem() }}</strong>
    -
    <strong>{{ $institutions->lastItem() }}</strong>

    dari

    <strong>{{ $institutions->total() }}</strong>
    instansi

</div>

</div>

@endsection