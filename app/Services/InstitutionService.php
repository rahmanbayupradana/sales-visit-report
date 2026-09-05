<?php

namespace App\Services;

use App\Models\Institution;
use App\Repositories\InstitutionRepository;
use Illuminate\Support\Facades\DB;

class InstitutionService
{
    private InstitutionRepository $institutionRepository;

    public function __construct(
        InstitutionRepository $institutionRepository
    ) {
        $this->institutionRepository = $institutionRepository;
    }

    public function create(array $data): Institution
    {
        return DB::transaction(function () use ($data) {
            return $this->institutionRepository->create($data);
        });
    }

    public function update(
        Institution $institution,
        array $data
    ): bool {
        return DB::transaction(function () use (
            $institution,
            $data
        ) {
            return $this->institutionRepository->update(
                $institution,
                $data
            );
        });
    }

    public function delete(Institution $institution): bool
    {
        return DB::transaction(function () use ($institution) {
            return $this->institutionRepository->delete(
                $institution
            );
        });
    }
}