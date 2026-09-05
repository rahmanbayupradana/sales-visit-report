<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Sales Visit Report')
    </title>

    <style>

        html,
body {
    margin: 0;
    padding: 0;
    width: 100%;
    min-height: 100%;
}

* {
    box-sizing: border-box;
}

body {
    overflow-x: hidden;
}

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f7f7f8;
            color: #111827;
        }

        /* =========================
           LAYOUT
        ========================= */

        .app {
            display: flex;
            min-height: 100vh;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 250px;

            background: #ffffff;

            border-right:
                1px solid #e5e7eb;

            position: fixed;

            top: 0;
            left: 0;
            bottom: 0;

            display: flex;
            flex-direction: column;

            z-index: 100;
        }

        /* =========================
           LOGO
        ========================= */

        .brand {
            height: 70px;

            display: flex;

            align-items: center;

            padding:
                0 20px;

            border-bottom:
                1px solid #e5e7eb;
        }

        .brand-icon {
            width: 40px;
            height: 40px;

            background: #111827;

            color: white;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-right: 12px;

            font-size: 18px;
        }

        .brand-text h2 {
            font-size: 16px;

            font-weight: 700;
        }

        .brand-text span {
            display: block;

            font-size: 10px;

            color: #9ca3af;

            margin-top: 3px;

            letter-spacing: .5px;
        }

        /* =========================
           MENU
        ========================= */

        .menu {
            padding: 20px 12px;
        }

        .menu-title {
            font-size: 11px;

            color: #9ca3af;

            text-transform: uppercase;

            padding:
                0 12px 10px;
        }

        .menu a {
            display: flex;

            align-items: center;

            gap: 12px;

            padding:
                12px;

            margin-bottom: 4px;

            text-decoration: none;

            color: #4b5563;

            border-radius: 8px;

            font-size: 14px;

            transition:
                background .2s,
                color .2s;
        }

        .menu a:hover {
            background: #f3f4f6;

            color: #111827;
        }

        .menu a.active {
            background: #f3f4f6;

            color: #111827;

            font-weight: 600;
        }

        .menu-icon {
            width: 20px;

            text-align: center;

            font-size: 17px;
        }

        /* =========================
           USER AREA SIDEBAR
        ========================= */

        .sidebar-user {
            margin-top: auto;

            padding: 15px;

            border-top:
                1px solid #e5e7eb;
        }

        .user-box {
            display: flex;

            align-items: center;

            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: #111827;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: bold;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-info strong {
            display: block;

            font-size: 13px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .user-info span {
            font-size: 11px;

            color: #9ca3af;
        }

        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 250px;

            width: calc(100% - 250px);

            min-height: 100vh;
        }

        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            height: 70px;

            background: #ffffff;

            border-bottom:
                1px solid #e5e7eb;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                0 30px;
        }

        .page-title {
            font-size: 14px;

            color: #6b7280;
        }

        .topbar-right {
            display: flex;

            align-items: center;

            gap: 15px;
        }

        .role-badge {
            font-size: 11px;

            padding:
                5px 10px;

            border-radius: 20px;

            background: #f3f4f6;

            color: #374151;

            font-weight: 600;
        }

        .logout-button {
            border: none;

            background: transparent;

            cursor: pointer;

            color: #6b7280;

            font-size: 13px;
        }

        .logout-button:hover {
            color: #dc2626;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            padding: 30px;
        }

        .page-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 26px;

            font-weight: 700;
        }

        .page-header p {
            color: #6b7280;

            margin-top: 6px;

            font-size: 13px;
        }

        /* =========================
           CARDS
        ========================= */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;

            margin-bottom: 25px;
        }

        .stat-card {
            background: white;

            border:
                1px solid #e5e7eb;

            border-radius: 12px;

            padding: 22px;
        }

        .stat-card-title {
            font-size: 13px;

            color: #6b7280;

            margin-bottom: 10px;
        }

        .stat-card-value {
            font-size: 30px;

            font-weight: 700;
        }

        .stat-card-description {
            font-size: 11px;

            color: #9ca3af;

            margin-top: 7px;
        }

        /* =========================
           PANEL
        ========================= */

        .panel {
            background: white;

            border:
                1px solid #e5e7eb;

            border-radius: 12px;

            overflow: hidden;
        }

        .panel-header {
            padding: 20px;

            border-bottom:
                1px solid #e5e7eb;
        }

        .panel-header h2 {
            font-size: 16px;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            border: none;

            border-radius: 7px;

            padding:
                10px 15px;

            cursor: pointer;

            text-decoration: none;

            font-size: 13px;
        }

        .btn-primary {
            background: #111827;

            color: white;
        }

        .btn-primary:hover {
            background: #374151;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            padding: 13px 16px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 13px;
        }

        .alert-success {
            background: #ecfdf5;

            color: #047857;

            border:
                1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;

            color: #b91c1c;

            border:
                1px solid #fecaca;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;

                width:
                    calc(100% - 210px);
            }

            .stats {
                grid-template-columns:
                    1fr;
            }

        }

        @media (max-width: 650px) {

            .sidebar {
                width: 70px;
            }

            .brand-text,
            .menu-title,
            .menu a span:not(.menu-icon),
            .user-info {
                display: none;
            }

            .brand {
                justify-content: center;

                padding: 0;
            }

            .brand-icon {
                margin: 0;
            }

            .menu a {
                justify-content: center;
            }

            .sidebar-user {
                padding: 10px;
            }

            .user-box {
                justify-content: center;
            }

            .main {
                margin-left: 70px;

                width:
                    calc(100% - 70px);
            }

            .content {
                padding: 20px;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

<div class="app">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="brand">

            <div class="brand-icon">
                📊
            </div>

            <div class="brand-text">

                <h2>
                    Sales Visit Report
                </h2>

                <span>
                    ADMIN PANEL
                </span>

            </div>

        </div>


        <nav class="menu">

            <div class="menu-title">
                Menu
            </div>

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >

                <span class="menu-icon">
                    ▦
                </span>

                <span>
                    Dashboard
                </span>

            </a>




            {{-- Laporan --}}
            @auth

                <a
                      href="{{ route('visits.index') }}"
                        class="{{ request()->routeIs('visits.*') ? 'active' : '' }}"
                    class="{{ request()->routeIs('visits.*') ? 'active' : '' }}"
                >

                    <span class="menu-icon">
                        ▤
                    </span>

                    <span>
                        Laporan
                    </span>

                </a>

                <a href="{{ route('institutions.index') }}"
                     class="{{ request()->routeIs('institutions.*') ? 'active' : '' }}">
                        <span>🏢</span>
                             <span>Instansi</span>
                </a>

            @endauth


            {{-- Kelola User hanya Admin --}}
            @auth

                @if(auth()->user()->role === 'admin')

                     <a href="{{ route('users.index') }}"
       class="{{ request()->routeIs('users.*') ? 'active' : '' }}">

        <span>♙</span>

        <span>Kelola User</span>

    </a>


                @endif

            @endauth

        </nav>


        {{-- USER --}}
        @auth

            <div class="sidebar-user">

                <div class="user-box">

                    <div class="avatar">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>

                    <div class="user-info">

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <span>
                            {{ strtoupper(auth()->user()->role) }}
                        </span>

                    </div>

                </div>

            </div>

        @endauth

    </aside>


    {{-- MAIN --}}
    <main class="main">

        {{-- TOPBAR --}}
        <header class="topbar">

            <div class="page-title">

                @yield('breadcrumb', 'Dashboard')

            </div>

            <div class="topbar-right">

                @auth

                    <span class="role-badge">

                        {{ strtoupper(auth()->user()->role) }}

                    </span>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="logout-button"
                        >
                            Logout
                        </button>

                    </form>

                @endauth

            </div>

        </header>


        {{-- CONTENT --}}
        <section class="content">

            {{-- Success --}}
            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Error --}}
            @if(session('error'))

                <div class="alert alert-error">

                    {{ session('error') }}

                </div>

            @endif


            @yield('content')

        </section>

    </main>

</div>

@stack('scripts')

</body>

</html>