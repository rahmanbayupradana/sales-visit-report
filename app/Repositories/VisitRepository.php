<?php

namespace App\Repositories;

use App\Models\Visit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class VisitRepository
{
    /**
     * Query utama untuk laporan kunjungan.
     *
     * Digunakan oleh:
     * - halaman laporan
     * - export Excel
     * - export PDF
     */
    public function getFilteredQuery(
        array $filters,
        ?int $userId = null,
        bool $isAdmin = false
    ): Builder {
        $query = Visit::query()->with([
            'sales',
            'institution',
            'type',
            'result',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Hak akses Sales
        |--------------------------------------------------------------------------
        */

        if (!$isAdmin && $userId !== null) {
            $query->where('user_id', $userId);
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {

                $q->whereHas('institution', function ($institution) use ($search) {

                    $institution
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('pic_name', 'like', "%{$search}%");

                });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Sales
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['sales_id'])) {
            $query->where(
                'user_id',
                $filters['sales_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Instansi
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['institution_id'])) {
            $query->where(
                'institution_id',
                $filters['institution_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Jenis Kunjungan
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['visit_type_id'])) {
            $query->where(
                'visit_type_id',
                $filters['visit_type_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Hasil Kunjungan
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['visit_result_id'])) {
            $query->where(
                'visit_result_id',
                $filters['visit_result_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Bulan
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['month'])) {
            $query->whereMonth(
                'visit_date',
                $filters['month']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tahun
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['year'])) {
            $query->whereYear(
                'visit_date',
                $filters['year']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal Dari
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['date_from'])) {
            $query->whereDate(
                'visit_date',
                '>=',
                $filters['date_from']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal Sampai
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['date_to'])) {
            $query->whereDate(
                'visit_date',
                '<=',
                $filters['date_to']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        return $query
            ->orderByDesc('visit_date')
            ->orderByDesc('visit_time');
    }


    /**
     * Ambil laporan dengan pagination.
     */
    public function getFiltered(
        array $filters,
        ?int $userId = null,
        bool $isAdmin = false
    ): LengthAwarePaginator {
        return $this->getFilteredQuery(
            $filters,
            $userId,
            $isAdmin
        )
            ->paginate(10)
            ->withQueryString();
    }


    /**
     * Ambil satu laporan berdasarkan ID.
     */
    public function findById(int $id): Visit
    {
        return Visit::with([
            'sales',
            'institution',
            'type',
            'result',
        ])->findOrFail($id);
    }


    /**
     * Membuat laporan baru.
     */
    public function create(array $data): Visit
    {
        return Visit::create($data);
    }


    /**
     * Update laporan.
     */
    public function update(
        Visit $visit,
        array $data
    ): bool {
        return $visit->update($data);
    }


    /**
     * Hapus laporan.
     */
    public function delete(Visit $visit): bool
    {
        return $visit->delete();
    }


    /**
     * Hitung total laporan.
     */
    public function count(
        ?int $userId = null,
        bool $isAdmin = false
    ): int {
        $query = Visit::query();

        if (!$isAdmin && $userId !== null) {
            $query->where('user_id', $userId);
        }

        return $query->count();
    }


    /**
     * Hitung laporan hari ini.
     */
    public function countToday(
        ?int $userId = null,
        bool $isAdmin = false
    ): int {
        $query = Visit::query()
            ->whereDate('visit_date', today());

        if (!$isAdmin && $userId !== null) {
            $query->where('user_id', $userId);
        }

        return $query->count();
    }
}