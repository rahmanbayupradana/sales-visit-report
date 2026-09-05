@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('breadcrumb', 'Laporan / Detail Kunjungan')

@section('content')

<div class="page-header">

    <div>

        <h1>
            Detail Kunjungan
        </h1>

        <p>
            Informasi lengkap kunjungan.
        </p>

    </div>

    <div>

        <a
            href="{{ route('visits.index') }}"
            class="btn btn-reset"
        >
            ← Kembali
        </a>

        @if(
            auth()->user()->role === 'admin'
            ||
            auth()->id() === $visit->user_id
        )

            <a
                href="{{ route(
                    'visits.edit',
                    $visit->id
                ) }}"
                class="btn btn-primary"
            >
                Edit
            </a>

        @endif

    </div>

</div>


<div class="detail-card">

    <div class="detail-row">

        <span>
            Sales
        </span>

        <strong>
            {{ $visit->sales->name }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            Instansi
        </span>

        <strong>
            {{ $visit->institution->name }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            PIC
        </span>

        <strong>
            {{ $visit->institution->pic_name ?? '-' }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            Telepon
        </span>

        <strong>
            {{ $visit->institution->phone ?? '-' }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            Alamat
        </span>

        <strong>
            {{ $visit->institution->address ?? '-' }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            Waktu
        </span>

        <strong>
            {{ $visit->visit_date->format('d M Y') }}
            -
            {{ substr($visit->visit_time, 0, 5) }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            Jenis
        </span>

        <strong>
            {{ $visit->type->name }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            Hasil
        </span>

        <strong>
            {{ $visit->result->name }}
        </strong>

    </div>


    <div class="detail-row">

        <span>
            Catatan
        </span>

        <strong>
            {{ $visit->notes ?: '-' }}
        </strong>

    </div>

</div>


<style>

    .detail-card {

        background: white;

        border:
            1px solid #e5e7eb;

        border-radius: 12px;

        padding: 10px;

        max-width: 850px;
    }

    .detail-row {

        display: grid;

        grid-template-columns:
            180px 1fr;

        padding: 18px 15px;

        border-bottom:
            1px solid #f0f0f0;

        font-size: 13px;
    }

    .detail-row:last-child {

        border-bottom: none;
    }

    .detail-row span {

        color: #9ca3af;
    }

    .detail-row strong {

        color: #111827;

        line-height: 1.5;
    }

    @media(max-width: 600px) {

        .detail-row {

            grid-template-columns: 1fr;

            gap: 5px;
        }

    }

</style>

@endsection