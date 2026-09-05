<?php

namespace App\Services;

use App\Models\Visit;
use App\Repositories\VisitRepository;
use Illuminate\Support\Facades\DB;

class VisitService
{
    public function __construct(
        private VisitRepository $visitRepository
    ) {
    }

    /**
     * Membuat visit baru.
     */
    public function create(array $data): Visit
    {
        return DB::transaction(function () use ($data) {

            return $this->visitRepository->create($data);

        });
    }

    /**
     * Update visit.
     */
    public function update(
        Visit $visit,
        array $data
    ): bool {

        return DB::transaction(function () use (
            $visit,
            $data
        ) {

            return $this->visitRepository->update(
                $visit,
                $data
            );

        });
    }

    /**
     * Delete visit.
     */
    public function delete(Visit $visit): bool
    {
        return DB::transaction(function () use ($visit) {

            return $this->visitRepository->delete($visit);

        });
    }
}