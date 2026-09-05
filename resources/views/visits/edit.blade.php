@extends('layouts.app')

@section('title', 'Edit Kunjungan')

@section('breadcrumb', 'Laporan / Edit Kunjungan')

@section('content')

<div class="page-header">

    <div>

        <h1>
            Edit Kunjungan
        </h1>

        <p>
            Perbarui data kunjungan.
        </p>

    </div>

    <a
        href="{{ route('visits.index') }}"
        class="btn btn-reset"
    >
        ← Kembali
    </a>

</div>


<div class="form-panel">

    <form
        action="{{ route(
            'visits.update',
            $visit->id
        ) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        {{-- SALES --}}

        @if(auth()->user()->role === 'admin')

            <div class="form-group">

                <label>
                    Sales
                </label>

                <select
                    name="user_id"
                    class="form-input"
                    required
                >

                    @foreach($sales as $sale)

                        <option
                            value="{{ $sale->id }}"
                            @selected(
                                old(
                                    'user_id',
                                    $visit->user_id
                                ) == $sale->id
                            )
                        >
                            {{ $sale->name }}
                        </option>

                    @endforeach

                </select>

                @error('user_id')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        @else

            <div class="form-group">

                <label>
                    Sales
                </label>

                <input
                    type="text"
                    class="form-input"
                    value="{{ $visit->sales->name }}"
                    disabled
                >

            </div>

        @endif


        {{-- INSTANSI --}}

        <div class="form-group">

            <label>
                Instansi
            </label>

            <select
                name="institution_id"
                class="form-input"
                required
            >

                @foreach($institutions as $institution)

                    <option
                        value="{{ $institution->id }}"
                        @selected(
                            old(
                                'institution_id',
                                $visit->institution_id
                            ) == $institution->id
                        )
                    >
                        {{ $institution->name }}
                    </option>

                @endforeach

            </select>

            @error('institution_id')

                <div class="error">
                    {{ $message }}
                </div>

            @enderror

        </div>


        <div class="two-column">

            <div class="form-group">

                <label>
                    Tanggal
                </label>

                <input
                    type="date"
                    name="visit_date"
                    class="form-input"
                    value="{{ old(
                        'visit_date',
                        $visit->visit_date->format('Y-m-d')
                    ) }}"
                    required
                >

                @error('visit_date')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group">

                <label>
                    Jam
                </label>

                <input
                    type="time"
                    name="visit_time"
                    class="form-input"
                    value="{{ old(
                        'visit_time',
                        substr($visit->visit_time, 0, 5)
                    ) }}"
                    required
                >

                @error('visit_time')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        </div>


        <div class="two-column">

            <div class="form-group">

                <label>
                    Jenis Kunjungan
                </label>

                <select
                    name="visit_type_id"
                    class="form-input"
                    required
                >

                    @foreach($visitTypes as $type)

                        <option
                            value="{{ $type->id }}"
                            @selected(
                                old(
                                    'visit_type_id',
                                    $visit->visit_type_id
                                ) == $type->id
                            )
                        >
                            {{ $type->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="form-group">

                <label>
                    Hasil Kunjungan
                </label>

                <select
                    name="visit_result_id"
                    class="form-input"
                    required
                >

                    @foreach($visitResults as $result)

                        <option
                            value="{{ $result->id }}"
                            @selected(
                                old(
                                    'visit_result_id',
                                    $visit->visit_result_id
                                ) == $result->id
                            )
                        >
                            {{ $result->name }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        <div class="form-group">

            <label>
                Catatan
            </label>

            <textarea
                name="notes"
                class="form-input"
                rows="5"
            >{{ old('notes', $visit->notes) }}</textarea>

        </div>


        <div class="form-actions">

            <a
                href="{{ route('visits.index') }}"
                class="btn btn-reset"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>


<style>

    .form-panel {

        background: white;

        border:
            1px solid #e5e7eb;

        border-radius: 12px;

        padding: 25px;

        max-width: 850px;
    }

    .form-group {

        margin-bottom: 20px;
    }

    .form-group label {

        display: block;

        font-size: 13px;

        font-weight: 600;

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

    textarea.form-input {

        resize: vertical;

        font-family: inherit;
    }

    .two-column {

        display: grid;

        grid-template-columns:
            1fr 1fr;

        gap: 20px;
    }

    .error {

        color: #dc2626;

        font-size: 12px;

        margin-top: 5px;
    }

    .form-actions {

        display: flex;

        justify-content: flex-end;

        gap: 10px;

        padding-top: 10px;

        border-top:
            1px solid #e5e7eb;
    }

    .btn-reset {

        background: #f3f4f6;

        color: #374151;

    }

    @media(max-width: 700px) {

        .two-column {

            grid-template-columns: 1fr;
        }

    }

</style>

@endsection