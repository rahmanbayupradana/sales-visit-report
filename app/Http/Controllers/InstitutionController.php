<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Repositories\InstitutionRepository;
use App\Services\InstitutionService;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    private InstitutionRepository $institutionRepository;

    private InstitutionService $institutionService;

    public function __construct(
        InstitutionRepository $institutionRepository,
        InstitutionService $institutionService
    ) {
        $this->institutionRepository = $institutionRepository;
        $this->institutionService = $institutionService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $institutions = $this->institutionRepository->getAll(
            $user->id,
            $user->role === 'admin',
            $request->search
        );

        return view(
            'institutions.index',
            compact('institutions')
        );
    }

    public function create()
    {
        return view('institutions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'pic_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'address' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Instansi otomatis menjadi milik Sales yang login
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'admin') {
         $validated['user_id'] = null;
         } else {
         $validated['user_id'] = auth()->id();
         }

        $this->institutionService->create($validated);

        return redirect()
            ->route('institutions.index')
            ->with(
                'success',
                'Instansi berhasil ditambahkan.'
            );
    }

    public function show(Institution $institution)
    {
        $this->authorizeInstitution($institution);

        return view(
            'institutions.show',
            compact('institution')
        );
    }

    public function edit(Institution $institution)
    {
        $this->authorizeInstitution($institution);

        return view(
            'institutions.edit',
            compact('institution')
        );
    }

    public function update(
        Request $request,
        Institution $institution
    ) {
        $this->authorizeInstitution($institution);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'pic_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'address' => [
                'nullable',
                'string',
            ],
        ]);

        $this->institutionService->update(
            $institution,
            $validated
        );

        return redirect()
            ->route('institutions.index')
            ->with(
                'success',
                'Instansi berhasil diperbarui.'
            );
    }

    public function destroy(Institution $institution)
    {
        if (auth()->user()->role !== 'admin') {
            abort(
                403,
                'Sales tidak dapat menghapus instansi.'
            );
        }

        $this->institutionService->delete($institution);

        return redirect()
            ->route('institutions.index')
            ->with(
                'success',
                'Instansi berhasil dihapus.'
            );
    }

    private function authorizeInstitution(
        Institution $institution
    ): void {

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Admin boleh akses semua
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Sales hanya boleh akses instansi miliknya
        |--------------------------------------------------------------------------
        */

        if ($institution->user_id !== $user->id) {
            abort(
                403,
                'Anda tidak memiliki akses ke instansi ini.'
            );
        }
    }
}