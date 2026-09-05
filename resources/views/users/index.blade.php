@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<style>

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
        min-height: 40px;
        padding: 0 15px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        border-radius: 8px;
        border: none;

        text-decoration: none;

        font-size: 14px;
        font-weight: 600;

        cursor: pointer;
        box-sizing: border-box;
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

    .btn-secondary:hover {
        background: #e5e7eb;
    }


    /* SEARCH */

    .filter-card {
        background: white;

        border: 1px solid #e5e7eb;

        border-radius: 12px;

        padding: 18px;

        margin-bottom: 20px;
    }

    .filter-form {
        display: flex;

        align-items: end;

        gap: 10px;

        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;

        min-width: 250px;
    }

    .filter-group label {
        display: block;

        margin-bottom: 6px;

        font-size: 12px;

        font-weight: 600;

        color: #4b5563;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;

        height: 40px;

        box-sizing: border-box;

        padding: 0 12px;

        border: 1px solid #d1d5db;

        border-radius: 8px;

        background: white;

        color: #111827;

        font-size: 13px;

        outline: none;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #2563eb;

        box-shadow:
            0 0 0 3px rgba(37, 99, 235, .08);
    }


    /* TABLE */

    .table-card {
        background: white;

        border: 1px solid #e5e7eb;

        border-radius: 12px;

        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .user-table {
        width: 100%;

        border-collapse: collapse;
    }

    .user-table th {
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

    .user-table td {
        padding: 14px;

        color: #374151;

        font-size: 13px;

        border-bottom:
            1px solid #f3f4f6;

        vertical-align: middle;
    }

    .user-table tbody tr:hover {
        background: #f9fafb;
    }

    .user-table tbody tr:last-child td {
        border-bottom: none;
    }


    /* USER */

    .user-name {
        font-weight: 600;

        color: #111827;
    }

    .user-email {
        color: #6b7280;

        font-size: 12px;
    }


    /* BADGES */

    .badge {
        display: inline-flex;

        align-items: center;

        padding: 5px 9px;

        border-radius: 999px;

        font-size: 11px;

        font-weight: 700;
    }

    .badge-admin {
        background: #ede9fe;

        color: #6d28d9;
    }

    .badge-sales {
        background: #eff6ff;

        color: #1d4ed8;
    }

    .badge-active {
        background: #dcfce7;

        color: #166534;
    }

    .badge-inactive {
        background: #fee2e2;

        color: #991b1b;
    }


    /* ACTION */

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

        border: none;

        border-radius: 7px;

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

    .action-password {
        background: #f3e8ff;

        color: #7e22ce;
    }

    .action-status {
        background: #f3f4f6;

        color: #374151;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }


    /* PAGINATION */

    .pagination-wrapper {
        padding: 16px;

        border-top:
            1px solid #f3f4f6;
    }


    /* EMPTY */

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

        .filter-form {
            flex-direction: column;

            align-items: stretch;
        }

        .filter-group {
            min-width: 0;
        }

    }

</style>


{{-- HEADER --}}

<div class="page-header">

    <div>

        <h1 class="page-title">
            Kelola User
        </h1>

        <p class="page-subtitle">
            Kelola akun Admin dan Sales.
        </p>

    </div>


    <div class="header-actions">

        <a
            href="{{ route('users.create') }}"
            class="btn-primary"
        >
            ＋ Tambah User
        </a>

    </div>

</div>


{{-- FILTER --}}

<div class="filter-card">

    <form
        method="GET"
        action="{{ route('users.index') }}"
        class="filter-form"
    >

        <div class="filter-group">

            <label>
                Cari User
            </label>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nama atau email..."
            >

        </div>


        <div
            class="filter-group"
            style="max-width: 180px;"
        >

            <label>
                Role
            </label>

            <select name="role">

                <option value="">
                    Semua Role
                </option>

                <option
                    value="admin"
                    {{ request('role') === 'admin' ? 'selected' : '' }}
                >
                    Admin
                </option>

                <option
                    value="sales"
                    {{ request('role') === 'sales' ? 'selected' : '' }}
                >
                    Sales
                </option>

            </select>

        </div>


        <button
            type="submit"
            class="btn-primary"
        >
            🔍 Cari
        </button>


        <a
            href="{{ route('users.index') }}"
            class="btn-secondary"
        >
            Reset
        </a>

    </form>

</div>


{{-- TABLE --}}

<div class="table-card">

    <div class="table-wrapper">

        <table class="user-table">

            <thead>

                <tr>

                    <th width="5%">
                        No
                    </th>

                    <th>
                        User
                    </th>

                    <th>
                        Role
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Terdaftar
                    </th>

                    <th width="150">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>
                            {{ $users->firstItem() + $loop->index }}
                        </td>


                        <td>

                            <div class="user-name">
                                {{ $user->name }}
                            </div>

                            <div class="user-email">
                                {{ $user->email }}
                            </div>

                        </td>


                        <td>

                            @if($user->role === 'admin')

                                <span class="badge badge-admin">
                                    ADMIN
                                </span>

                            @else

                                <span class="badge badge-sales">
                                    SALES
                                </span>

                            @endif

                        </td>


                        <td>

                            @if($user->is_active)

                                <span class="badge badge-active">
                                    AKTIF
                                </span>

                            @else

                                <span class="badge badge-inactive">
                                    NONAKTIF
                                </span>

                            @endif

                        </td>


                        <td>

                            {{ $user->created_at?->format('d/m/Y') ?? '-' }}

                        </td>


                        <td>

                            <div class="action-buttons">


                                {{-- DETAIL --}}

                                <a
                                    href="{{ route(
                                        'users.show',
                                        $user->id
                                    ) }}"
                                    class="action-btn action-view"
                                    title="Detail"
                                >
                                    👁
                                </a>


                                {{-- EDIT --}}

                                <a
                                    href="{{ route(
                                        'users.edit',
                                        $user->id
                                    ) }}"
                                    class="action-btn action-edit"
                                    title="Edit"
                                >
                                    ✏
                                </a>


                                {{-- RESET PASSWORD --}}

                                <a
                                    href="{{ route(
                                        'users.edit',
                                        $user->id
                                    ) }}#password"
                                    class="action-btn action-password"
                                    title="Reset Password"
                                >
                                    🔑
                                </a>


                                {{-- STATUS --}}

                                @if($user->id !== auth()->id())

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'users.toggle-status',
                                            $user->id
                                        ) }}"
                                        onsubmit="
                                            return confirm(
                                                'Ubah status user ini?'
                                            )
                                        "
                                        style="display:inline;"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="action-btn action-status"
                                            title="Ubah Status"
                                        >
                                            {{ $user->is_active ? '⏸' : '▶' }}
                                        </button>

                                    </form>

                                @endif


                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="empty-state"
                        >
                            Belum ada user.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="pagination-wrapper">

        {{ $users->links() }}

    </div>

</div>

@endsection