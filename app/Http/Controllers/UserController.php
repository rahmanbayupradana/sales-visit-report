<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private UserRepository $userRepository;

    private UserService $userService;


    public function __construct(
        UserRepository $userRepository,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $users = $this->userRepository->getAll(
            $request->search,
            $request->role
        );

        return view(
            'users.index',
            compact('users')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('users.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'sales',
                ]),
            ],

        ]);


        $validated['is_active'] = true;

        $this->userService->create($validated);


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(User $user)
    {
        return view(
            'users.show',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(User $user)
    {
        return view(
            'users.edit',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ) {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'sales',
                ]),
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Jangan sampai Admin menghilangkan akses dirinya sendiri
        |--------------------------------------------------------------------------
        */

        if (
            $user->id === auth()->id()
            &&
            $validated['role'] !== 'admin'
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'role' =>
                        'Anda tidak dapat mengubah role Admin sendiri.'
                ]);
        }


        $this->userService->update(
            $user,
            $validated
        );


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function resetPassword(
        Request $request,
        User $user
    ) {

        $validated = $request->validate([

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

        ]);


        $this->userService->resetPassword(
            $user,
            $validated['password']
        );


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Password user berhasil direset.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TOGGLE STATUS
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh menonaktifkan dirinya sendiri
        |--------------------------------------------------------------------------
        */

        if ($user->id === auth()->id()) {

            return back()
                ->withErrors([
                    'user' =>
                        'Anda tidak dapat menonaktifkan akun sendiri.'
                ]);
        }


        $this->userService->toggleStatus($user);


        $message = $user->is_active
            ? 'User berhasil diaktifkan.'
            : 'User berhasil dinonaktifkan.';


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                $message
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user)
    {
        /*
        | Untuk saat ini kita tidak menghapus user.
        | Gunakan status aktif/nonaktif.
        */

        return back()
            ->withErrors([
                'user' =>
                    'User tidak dihapus. Gunakan fitur Aktif/Nonaktif.'
            ]);
    }
}