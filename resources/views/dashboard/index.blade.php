@extends('layouts.app')

@section('content')

<div class="dashboard">

    {{-- HEADER --}}
    <div class="dashboard-header">

        <div>
            <div class="eyebrow">
                EXECUTIVE DASHBOARD
            </div>

            <h1>
                Selamat datang, {{ auth()->user()->name }} 👋
            </h1>

            <p>
                Monitoring aktivitas sales dan kunjungan hari ini.
            </p>
        </div>

        <div class="dashboard-date">
            <div class="date-icon">📅</div>

            <div>
                <strong>
                    {{ now()->translatedFormat('d F Y') }}
                </strong>

                <span>
                    {{ now()->translatedFormat('l') }}
                </span>
            </div>
        </div>

    </div>


    {{-- KPI --}}
    <div class="kpi-grid">

        <div class="kpi-card">

            <div class="kpi-icon blue">
                📋
            </div>

            <div class="kpi-content">
                <span>Total Kunjungan</span>

                <strong>
                    {{ number_format($totalVisits) }}
                </strong>

                <small>
                    Seluruh periode
                </small>
            </div>

        </div>


        <div class="kpi-card">

            <div class="kpi-icon green">
                📅
            </div>

            <div class="kpi-content">
                <span>Kunjungan Hari Ini</span>

                <strong>
                    {{ number_format($todayVisits) }}
                </strong>

                <small>
                    Aktivitas hari ini
                </small>
            </div>

        </div>


        <div class="kpi-card">

            <div class="kpi-icon purple">
                📊
            </div>

            <div class="kpi-content">

                <span>Kunjungan Bulan Ini</span>

                <strong>
                    {{ number_format($thisMonthVisits) }}
                </strong>

                @php
                    $difference = $thisMonthVisits - $lastMonthVisits;
                @endphp

                <small class="{{ $difference >= 0 ? 'positive' : 'negative' }}">

                    @if($difference > 0)
                        ▲ {{ $difference }}
                        dibanding bulan lalu
                    @elseif($difference < 0)
                        ▼ {{ abs($difference) }}
                        dibanding bulan lalu
                    @else
                        Sama dengan bulan lalu
                    @endif

                </small>

            </div>

        </div>


        <div class="kpi-card">

            <div class="kpi-icon orange">
                🏢
            </div>

            <div class="kpi-content">

                <span>Total Instansi</span>

                <strong>
                    {{ number_format($totalInstitutions) }}
                </strong>

                <small>
                    Instansi terdaftar
                </small>

            </div>

        </div>

    </div>


    {{-- MAIN GRID --}}
    <div class="dashboard-grid">

        {{-- 7 DAYS --}}
        <div class="dashboard-card chart-card">

            <div class="card-header">

                <div>
                    <h2>Aktivitas Kunjungan</h2>

                    <p>
                        7 hari terakhir
                    </p>
                </div>

                <div class="card-badge">
                    7 DAYS
                </div>

            </div>


            <div class="bar-chart">

                @php
                    $maxVisit = collect($visitsLast7Days)->max('total');
                    $maxVisit = max($maxVisit, 1);
                @endphp

                @foreach($visitsLast7Days as $day)

                    @php
                        $height = ($day['total'] / $maxVisit) * 100;
                    @endphp

                    <div class="bar-column">

                        <div class="bar-value">
                            {{ $day['total'] }}
                        </div>

                        <div class="bar-wrapper">

                            <div
                                class="bar"
                                style="height: {{ max($height, 4) }}%;"
                            ></div>

                        </div>

                        <div class="bar-label">
                            {{ $day['day'] }}
                        </div>

                        <div class="bar-date">
                            {{ $day['date'] }}
                        </div>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- SALES RANKING --}}
        <div class="dashboard-card">

            <div class="card-header">

                <div>
                    <h2>Ranking Sales</h2>

                    <p>
                        Berdasarkan jumlah kunjungan
                    </p>
                </div>

                <div class="card-badge">
                    TOP SALES
                </div>

            </div>


            <div class="ranking-list">

                @forelse($visitsBySales as $index => $sales)

                    <div class="ranking-item">

                        <div class="rank-number">
                            {{ $index + 1 }}
                        </div>

                        <div class="avatar">
                            {{ strtoupper(substr($sales->sales->name ?? '?', 0, 1)) }}
                        </div>

                        <div class="sales-info">

                            <strong>
                                {{ $sales->sales->name ?? 'Unknown' }}
                            </strong>

                            <span>
                                {{ $sales->total }} kunjungan
                            </span>

                        </div>

                        <div class="rank-progress">

                            <div
                                class="progress-fill"
                                style="
                                    width:
                                    {{ $visitsBySales->max('total') > 0
                                        ? ($sales->total / $visitsBySales->max('total')) * 100
                                        : 0
                                    }}%;
                                "
                            ></div>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">
                        Belum ada data sales.
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- SECOND ROW --}}
    <div class="dashboard-grid">

        {{-- RESULT --}}
        <div class="dashboard-card">

            <div class="card-header">

                <div>
                    <h2>Hasil Kunjungan</h2>

                    <p>
                        Distribusi hasil aktivitas
                    </p>
                </div>

            </div>


            <div class="result-list">

                @forelse($visitResultSummary as $result)

                    <div class="result-item">

                        <div class="result-top">

                            <span>
                                {{ $result->result->name ?? 'Unknown' }}
                            </span>

                            <strong>
                                {{ $result->percentage }}%
                            </strong>

                        </div>

                        <div class="result-progress">

                            <div
                                class="result-fill"
                                style="width: {{ $result->percentage }}%;"
                            ></div>

                        </div>

                        <small>
                            {{ $result->total }} kunjungan
                        </small>

                    </div>

                @empty

                    <div class="empty-state">
                        Belum ada data hasil kunjungan.
                    </div>

                @endforelse

            </div>

        </div>


        {{-- QUICK ACTION --}}
        <div class="dashboard-card">

            <div class="card-header">

                <div>
                    <h2>Quick Actions</h2>

                    <p>
                        Akses menu yang sering digunakan
                    </p>
                </div>

            </div>


            <div class="quick-actions">

                <a
                    href="{{ route('visits.create') }}"
                    class="quick-action"
                >

                    <div class="quick-icon blue">
                        ＋
                    </div>

                    <div>
                        <strong>
                            Tambah Kunjungan
                        </strong>

                        <span>
                            Buat laporan baru
                        </span>
                    </div>

                    <b>→</b>

                </a>


                <a
                    href="{{ route('visits.index') }}"
                    class="quick-action"
                >

                    <div class="quick-icon green">
                        📋
                    </div>

                    <div>
                        <strong>
                            Lihat Laporan
                        </strong>

                        <span>
                            Kelola laporan kunjungan
                        </span>
                    </div>

                    <b>→</b>

                </a>


                <a
                    href="{{ route('institutions.index') }}"
                    class="quick-action"
                >

                    <div class="quick-icon orange">
                        🏢
                    </div>

                    <div>
                        <strong>
                            Instansi
                        </strong>

                        <span>
                            Kelola data instansi
                        </span>
                    </div>

                    <b>→</b>

                </a>


                @if(auth()->user()->role === 'admin')

                    <a
                        href="{{ route('users.index') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon purple">
                            👥
                        </div>

                        <div>
                            <strong>
                                Kelola User
                            </strong>

                            <span>
                                Management akun pengguna
                            </span>
                        </div>

                        <b>→</b>

                    </a>

                @endif

            </div>

        </div>

    </div>


    {{-- RECENT VISITS --}}
    <div class="dashboard-card recent-card">

        <div class="card-header">

            <div>
                <h2>Aktivitas Terbaru</h2>

                <p>
                    5 laporan kunjungan terakhir
                </p>
            </div>

            <a
                href="{{ route('visits.index') }}"
                class="view-all"
            >
                Lihat Semua →
            </a>

        </div>


        <div class="table-wrapper">

            <table class="dashboard-table">

                <thead>

                    <tr>
                        <th>Tanggal</th>
                        <th>Sales</th>
                        <th>Instansi</th>
                        <th>Jenis</th>
                        <th>Hasil</th>
                        <th>Jam</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($recentVisits as $visit)

                        <tr>

                            <td>
                                <strong>
                                    {{ $visit->visit_date?->format('d/m/Y') }}
                                </strong>
                            </td>

                            <td>

                                <div class="table-user">

                                    <div class="mini-avatar">
                                        {{ strtoupper(substr($visit->sales->name ?? '?', 0, 1)) }}
                                    </div>

                                    <span>
                                        {{ $visit->sales->name ?? '-' }}
                                    </span>

                                </div>

                            </td>

                            <td>
                                {{ $visit->institution->name ?? '-' }}
                            </td>

                            <td>
                                {{ $visit->type->name ?? '-' }}
                            </td>

                            <td>

                                <span class="status-badge">
                                    {{ $visit->result->name ?? '-' }}
                                </span>

                            </td>

                            <td>
                                {{ $visit->visit_time ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="empty-table"
                            >
                                Belum ada laporan kunjungan.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

.dashboard {
    max-width: 1600px;
    margin: 0 auto;
}


/* HEADER */

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 28px;
}

.eyebrow {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.5px;
    margin-bottom: 7px;
    opacity: .6;
}

.dashboard-header h1 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
}

.dashboard-header p {
    margin: 7px 0 0;
    color: #64748b;
}

.dashboard-date {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 17px;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #fff;
}

.date-icon {
    font-size: 23px;
}

.dashboard-date strong,
.dashboard-date span {
    display: block;
}

.dashboard-date strong {
    font-size: 13px;
}

.dashboard-date span {
    margin-top: 3px;
    font-size: 11px;
    color: #64748b;
}


/* KPI */

.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 20px;
}

.kpi-card {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 17px;
    padding: 20px;
    transition: .2s;
}

.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(15, 23, 42, .06);
}

.kpi-icon,
.quick-icon {
    width: 45px;
    height: 45px;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.kpi-icon.blue,
.quick-icon.blue {
    background: #eff6ff;
}

.kpi-icon.green,
.quick-icon.green {
    background: #ecfdf5;
}

.kpi-icon.purple,
.quick-icon.purple {
    background: #f5f3ff;
}

.kpi-icon.orange,
.quick-icon.orange {
    background: #fff7ed;
}

.kpi-content span,
.kpi-content small {
    display: block;
}

.kpi-content span {
    font-size: 12px;
    color: #64748b;
}

.kpi-content strong {
    display: block;
    margin: 4px 0;
    font-size: 25px;
    line-height: 1;
}

.kpi-content small {
    font-size: 10px;
    color: #94a3b8;
}

.kpi-content small.positive {
    color: #16a34a;
}

.kpi-content small.negative {
    color: #dc2626;
}


/* GRID */

.dashboard-grid {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.dashboard-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 17px;
    padding: 22px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 22px;
}

.card-header h2 {
    margin: 0;
    font-size: 16px;
}

.card-header p {
    margin: 5px 0 0;
    color: #94a3b8;
    font-size: 11px;
}

.card-badge {
    font-size: 9px;
    font-weight: 800;
    padding: 6px 9px;
    border-radius: 7px;
    background: #f1f5f9;
    color: #64748b;
}


/* BAR CHART */

.bar-chart {
    height: 220px;
    display: flex;
    align-items: stretch;
    justify-content: space-around;
    gap: 10px;
}

.bar-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 0;
}

.bar-value {
    font-size: 10px;
    font-weight: 700;
    margin-bottom: 5px;
}

.bar-wrapper {
    flex: 1;
    width: 100%;
    max-width: 35px;
    display: flex;
    align-items: flex-end;
    border-radius: 9px 9px 3px 3px;
    background: #f8fafc;
    overflow: hidden;
}

.bar {
    width: 100%;
    border-radius: 8px 8px 3px 3px;
    background: #2563eb;
    transition: height .4s ease;
}

.bar-label {
    margin-top: 9px;
    font-size: 10px;
    font-weight: 700;
}

.bar-date {
    margin-top: 2px;
    font-size: 9px;
    color: #94a3b8;
}


/* RANKING */

.ranking-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.ranking-item {
    display: grid;
    grid-template-columns: 25px 35px 1fr 70px;
    align-items: center;
    gap: 10px;
}

.rank-number {
    font-size: 12px;
    font-weight: 800;
    color: #94a3b8;
    text-align: center;
}

.avatar,
.mini-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f1f5f9;
    font-weight: 800;
}

.avatar {
    width: 35px;
    height: 35px;
    font-size: 12px;
}

.sales-info strong,
.sales-info span {
    display: block;
}

.sales-info strong {
    font-size: 12px;
}

.sales-info span {
    margin-top: 2px;
    font-size: 10px;
    color: #94a3b8;
}

.rank-progress {
    height: 6px;
    background: #f1f5f9;
    border-radius: 20px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: inherit;
    background: #2563eb;
}


/* RESULT */

.result-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.result-top {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
}

.result-top strong {
    font-size: 11px;
}

.result-progress {
    height: 8px;
    margin-top: 8px;
    border-radius: 20px;
    background: #f1f5f9;
    overflow: hidden;
}

.result-fill {
    height: 100%;
    border-radius: inherit;
    background: #2563eb;
}

.result-item small {
    display: block;
    margin-top: 5px;
    font-size: 9px;
    color: #94a3b8;
}


/* QUICK ACTION */

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.quick-action {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: .2s;
}

.quick-action:hover {
    background: #f8fafc;
}

.quick-action strong,
.quick-action span {
    display: block;
}

.quick-action strong {
    font-size: 12px;
}

.quick-action span {
    margin-top: 2px;
    font-size: 10px;
    color: #94a3b8;
}

.quick-action b {
    margin-left: auto;
    color: #94a3b8;
}


/* TABLE */

.recent-card {
    margin-bottom: 20px;
}

.view-all {
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
}

.table-wrapper {
    overflow-x: auto;
}

.dashboard-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

.dashboard-table th {
    padding: 11px 10px;
    text-align: left;
    font-size: 10px;
    color: #94a3b8;
    font-weight: 700;
    border-bottom: 1px solid #e2e8f0;
}

.dashboard-table td {
    padding: 13px 10px;
    font-size: 11px;
    border-bottom: 1px solid #f1f5f9;
}

.table-user {
    display: flex;
    align-items: center;
    gap: 8px;
}

.mini-avatar {
    width: 28px;
    height: 28px;
    font-size: 10px;
}

.status-badge {
    display: inline-block;
    padding: 5px 8px;
    border-radius: 7px;
    background: #eff6ff;
    font-size: 9px;
    font-weight: 700;
}

.empty-state,
.empty-table {
    padding: 30px;
    text-align: center;
    color: #94a3b8;
    font-size: 12px;
}


/* RESPONSIVE */

@media (max-width: 1100px) {

    .kpi-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 700px) {

    .dashboard-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .dashboard-date {
        width: 100%;
        box-sizing: border-box;
    }

    .kpi-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-card {
        padding: 16px;
    }

    .ranking-item {
        grid-template-columns: 25px 35px 1fr;
    }

    .rank-progress {
        display: none;
    }

}

</style>

@endsection