<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }


    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $data['password'] = Hash::make(
                $data['password']
            );

            return $this->userRepository->create($data);
        });
    }


    public function update(
        User $user,
        array $data
    ): bool {

        return DB::transaction(function () use (
            $user,
            $data
        ) {

            return $this->userRepository->update(
                $user,
                $data
            );
        });
    }


    public function resetPassword(
        User $user,
        string $password
    ): bool {

        return DB::transaction(function () use (
            $user,
            $password
        ) {

            return $this->userRepository->updatePassword(
                $user,
                Hash::make($password)
            );
        });
    }


    public function toggleStatus(User $user): bool
    {
        return DB::transaction(function () use ($user) {

            return $this->userRepository->toggleStatus(
                $user
            );
        });
    }
}