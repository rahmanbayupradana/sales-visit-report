@extends('layouts.app')

@section('title', 'Tambah Kunjungan')

@section('breadcrumb', 'Laporan / Tambah Kunjungan')

@section('content')

<div class="form-card">

    <form
        method="POST"
        action="{{ route('visits.store') }}"
    >

        @csrf

        <div class="form-grid">


            {{-- SALES --}}

            @if(auth()->user()->role === 'admin')

                <div class="form-group full">

                    <label>
                        Sales *
                    </label>

                    <select
                        name="user_id"
                        required
                    >

                        <option value="">
                            -- Pilih Sales --
                        </option>

                        @foreach($sales as $salesUser)

                            <option
                                value="{{ $salesUser->id }}"
                                {{ old('user_id') == $salesUser->id ? 'selected' : '' }}
                            >
                                {{ $salesUser->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            @endif


            {{-- INSTANSI --}}

            <div class="form-group full">

                <label>
                    Instansi *
                </label>

                <select
                    name="institution_id"
                    required
                >

                    <option value="">
                        -- Pilih Instansi --
                    </option>

                    @foreach($institutions as $institution)

                        <option
                            value="{{ $institution->id }}"
                            {{ old('institution_id') == $institution->id ? 'selected' : '' }}
                        >
                            {{ $institution->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- TANGGAL --}}

            <div class="form-group">

                <label>
                    Tanggal *
                </label>

                <input
                    type="date"
                    name="visit_date"
                    value="{{ old(
                        'visit_date',
                        now()->format('Y-m-d')
                    ) }}"
                    required
                >

            </div>


            {{-- JAM --}}

            <div class="form-group">

                <label>
                    Jam *
                </label>

                <input
                    type="time"
                    name="visit_time"
                    value="{{ old(
                        'visit_time',
                        now()->format('H:i')
                    ) }}"
                    required
                >

            </div>


            {{-- JENIS --}}

            <div class="form-group">

                <label>
                    Jenis Kunjungan *
                </label>

                <select
                    name="visit_type_id"
                    required
                >

                    <option value="">
                        -- Pilih Jenis --
                    </option>

                    @foreach($visitTypes as $type)

                        <option
                            value="{{ $type->id }}"
                            {{ old('visit_type_id') == $type->id ? 'selected' : '' }}
                        >
                            {{ $type->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- HASIL --}}

            <div class="form-group">

                <label>
                    Hasil Kunjungan *
                </label>

                <select
                    name="visit_result_id"
                    required
                >

                    <option value="">
                        -- Pilih Hasil --
                    </option>

                    @foreach($visitResults as $result)

                        <option
                            value="{{ $result->id }}"
                            {{ old('visit_result_id') == $result->id ? 'selected' : '' }}
                        >
                            {{ $result->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- CATATAN --}}

            <div class="form-group full">

                <label>
                    Catatan
                </label>

                <textarea
                    name="notes"
                    placeholder="Masukkan catatan hasil kunjungan..."
                >{{ old('notes') }}</textarea>

            </div>

        </div>


        <div class="form-actions">

            <button
                type="submit"
                class="btn-primary"
            >
                💾 Simpan Kunjungan
            </button>

            <a
                href="{{ route('visits.index') }}"
                class="btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>


<style>

    .institution-select-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
}

.institution-select-wrapper select {
    flex: 1;
}

.btn-add-institution {
    display: inline-block;
    padding: 11px 15px;
    background: #16a34a;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    white-space: nowrap;
}

.btn-add-institution:hover {
    background: #15803d;
}

@media (max-width: 768px) {

    .institution-select-wrapper {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-add-institution {
        text-align: center;
    }

}

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

    .two-column {

        display: grid;

        grid-template-columns:
            1fr 1fr;

        gap: 20px;
    }

    textarea.form-input {

        resize: vertical;

        font-family: inherit;
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

    @media(max-width: 700px) {

        .two-column {

            grid-template-columns: 1fr;
        }

    }

    .form-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 25px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.form-group.full {
    grid-column: 1 / -1;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    min-height: 42px;

    box-sizing: border-box;

    padding: 10px 12px;

    border: 1px solid #d1d5db;
    border-radius: 8px;

    background: white;

    font-size: 14px;
    color: #111827;

    outline: none;
}

.form-group textarea {
    min-height: 120px;
    resize: vertical;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

.form-actions {
    display: flex;
    gap: 10px;

    margin-top: 25px;
    padding-top: 20px;

    border-top: 1px solid #f3f4f6;
}

@media (max-width: 700px) {

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-group.full {
        grid-column: auto;
    }

}

</style>

@endsection