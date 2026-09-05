<?php

namespace App\Repositories;

use App\Models\Institution;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InstitutionRepository
{
    public function getAll(
        ?int $userId = null,
        bool $isAdmin = false,
        ?string $search = null
    ): LengthAwarePaginator {

        $query = Institution::query()
            ->with('user');

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        | Admin dapat melihat semua instansi.
        |
        | Sales
        |--------------------------------------------------------------------------
        | Sales dapat melihat:
        | 1. Instansi master/global (user_id = NULL)
        | 2. Instansi yang dibuat oleh dirinya sendiri
        */

        if (!$isAdmin && $userId !== null) {

            $query->where(function ($q) use ($userId) {

                $q->whereNull('user_id')
                    ->orWhere('user_id', $userId);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('pic_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");

            });

        }

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function getAvailableForUser(
    ?int $userId = null,
    bool $isAdmin = false
) {
    $query = Institution::query()
        ->orderBy('name');

    if (!$isAdmin && $userId !== null) {

        $query->where(function ($q) use ($userId) {

            $q->whereNull('user_id')
                ->orWhere('user_id', $userId);

        });

    }

    return $query->get();
}


    public function findById(int $id): Institution
    {
        return Institution::findOrFail($id);
    }


    public function create(array $data): Institution
    {
        return Institution::create($data);
    }


    public function update(
        Institution $institution,
        array $data
    ): bool {
        return $institution->update($data);
    }


    public function delete(Institution $institution): bool
    {
        return $institution->delete();
    }
}