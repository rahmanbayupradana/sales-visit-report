<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function getAll(
        ?string $search = null,
        ?string $role = null
    ): LengthAwarePaginator {

        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Filter Role
        |--------------------------------------------------------------------------
        */

        if ($role) {
            $query->where('role', $role);
        }


        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }


    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }


    public function create(array $data): User
    {
        return User::create($data);
    }


    public function update(
        User $user,
        array $data
    ): bool {
        return $user->update($data);
    }


    public function updatePassword(
        User $user,
        string $password
    ): bool {
        return $user->update([
            'password' => $password,
        ]);
    }


    public function toggleStatus(User $user): bool
    {
        return $user->update([
            'is_active' => !$user->is_active,
        ]);
    }
}