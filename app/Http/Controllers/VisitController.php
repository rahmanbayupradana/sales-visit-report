<?php

namespace App\Http\Controllers;
use App\Models\Institution;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitResult;
use App\Models\VisitType;
use App\Repositories\VisitRepository;
use App\Services\VisitService;
use Illuminate\Http\Request;
use App\Repositories\InstitutionRepository;


class VisitController extends Controller
{

    private InstitutionRepository $institutionRepository;

    
   public function __construct(
        private VisitRepository $visitRepository,
        private VisitService $visitService,
        InstitutionRepository $institutionRepository
    ) {
        $this->visitRepository = $visitRepository;
        $this->visitService = $visitService;
        $this->institutionRepository = $institutionRepository;
    }

    /**
     * Menampilkan laporan visit.
     */
    public function index(Request $request)
{
    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Filter
    |--------------------------------------------------------------------------
    */

    $filters = [

        'search' => $request->input('search'),

        'month' => $request->input('month'),

        'year' => $request->input('year'),

        'sales_id' => $request->input('sales_id'),

        'institution_id' => $request->input('institution_id'),

        'visit_type_id' => $request->input('visit_type_id'),

        'visit_result_id' => $request->input('visit_result_id'),

        'date_from' => $request->input('date_from'),

        'date_to' => $request->input('date_to'),

    ];


    /*
    |--------------------------------------------------------------------------
    | Ambil laporan
    |--------------------------------------------------------------------------
    */

    $visits = $this->visitRepository->getFiltered(
        $filters,
        $user->id,
        $user->role === 'admin'
    );


    /*
    |--------------------------------------------------------------------------
    | Data dropdown
    |--------------------------------------------------------------------------
    */

    $sales = User::where('role', 'sales')
        ->orderBy('name')
        ->get();


    $institutions = $this->institutionRepository
        ->getAvailableForUser(
            $user->id,
            $user->role === 'admin'
        );


    $visitTypes = VisitType::orderBy('name')
        ->get();


    $visitResults = VisitResult::orderBy('name')
        ->get();


    return view(
        'visits.index',
        compact(
            'visits',
            'sales',
            'institutions',
            'visitTypes',
            'visitResults'
        )
    );
}

    /**
     * Form tambah visit.
     */
    public function create()
    {
        $user = auth()->user();

    $sales = User::where('role', 'sales')
        ->orderBy('name')
        ->get();

    $institutions = $this->institutionRepository
        ->getAvailableForUser(
            $user->id,
            $user->role === 'admin'
        );

    $visitTypes = VisitType::orderBy('name')->get();

    $visitResults = VisitResult::orderBy('name')->get();

    return view('visits.create', compact(
        'sales',
        'institutions',
        'visitTypes',
        'visitResults'
    ));
    }

    /**
     * Simpan visit.
     */
    public function store(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'institution_id' => [
            'required',
            'exists:institutions,id',
        ],

        'visit_type_id' => [
            'required',
            'exists:visit_types,id',
        ],

        'visit_result_id' => [
            'required',
            'exists:visit_results,id',
        ],

        'visit_date' => [
            'required',
            'date',
        ],

        'visit_time' => [
            'required',
        ],

        'notes' => [
            'nullable',
            'string',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Cek akses Instansi
    |--------------------------------------------------------------------------
    */

    $institution = Institution::findOrFail(
        $validated['institution_id']
    );

    if ($user->role !== 'admin') {

        $isAllowed =
            $institution->user_id === null ||
            $institution->user_id === $user->id;

        if (!$isAllowed) {

            abort(
                403,
                'Anda tidak memiliki akses ke instansi tersebut.'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Tentukan Sales
    |--------------------------------------------------------------------------
    */

    if ($user->role === 'admin') {

        $validated['user_id'] = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
            ],
        ])['user_id'];

    } else {

        $validated['user_id'] = $user->id;

    }


    /*
    |--------------------------------------------------------------------------
    | Simpan
    |--------------------------------------------------------------------------
    */

    $this->visitService->create($validated);

    return redirect()
        ->route('visits.index')
        ->with(
            'success',
            'Laporan kunjungan berhasil ditambahkan.'
        );
}

    /**
     * Detail visit.
     */
    public function show(int $id)
    {
        $visit = $this->visitRepository->findById($id);

        if (!$visit) {
            abort(404);
        }

        $this->authorizeVisit($visit);

        return view('visits.show', compact('visit'));
    }

    /**
     * Form edit.
     */
    public function edit($id)
{
    $visit = $this->visitRepository->findById($id);

    $this->authorizeVisit($visit);

    $user = auth()->user();

    $sales = User::where('role', 'sales')
        ->orderBy('name')
        ->get();

    $institutions = $this->institutionRepository
        ->getAvailableForUser(
            $user->id,
            $user->role === 'admin'
        );

    $visitTypes = VisitType::orderBy('name')->get();

    $visitResults = VisitResult::orderBy('name')->get();

    return view('visits.edit', compact(
        'visit',
        'sales',
        'institutions',
        'visitTypes',
        'visitResults'
    ));
}

    /**
     * Update visit.
     */
    public function update(Request $request, $id)
{
    $user = auth()->user();

    // Cari laporan kunjungan
    $visit = $this->visitRepository->findById($id);

    // Pastikan Sales hanya bisa mengedit laporan miliknya
    $this->authorizeVisit($visit);

    /*
    |--------------------------------------------------------------------------
    | Validasi input
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'institution_id' => [
            'required',
            'exists:institutions,id',
        ],

        'visit_type_id' => [
            'required',
            'exists:visit_types,id',
        ],

        'visit_result_id' => [
            'required',
            'exists:visit_results,id',
        ],

        'visit_date' => [
            'required',
            'date',
        ],

        'visit_time' => [
            'required',
        ],

        'notes' => [
            'nullable',
            'string',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | CEK AKSES INSTANSI
    |--------------------------------------------------------------------------
    */

    $institution = Institution::findOrFail(
        $validated['institution_id']
    );

    /*
    | Admin boleh memilih semua instansi
    */

    if ($user->role !== 'admin') {

        /*
        | Sales hanya boleh memilih:
        | 1. Instansi master
        | 2. Instansi miliknya sendiri
        */

        $isAllowed =
            $institution->user_id === null ||
            $institution->user_id === $user->id;

        if (!$isAllowed) {

            abort(
                403,
                'Anda tidak memiliki akses ke instansi tersebut.'
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | TENTUKAN SALES
    |--------------------------------------------------------------------------
    */

    if ($user->role === 'admin') {

        $salesData = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
            ],
        ]);

        $validated['user_id'] = $salesData['user_id'];

    } else {

        /*
        | Sales tidak boleh mengubah laporan
        | menjadi milik Sales lain
        */

        $validated['user_id'] = $user->id;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE DATABASE
    |--------------------------------------------------------------------------
    */

    $this->visitService->update(
        $visit,
        $validated
    );


    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('visits.index')
        ->with(
            'success',
            'Laporan kunjungan berhasil diperbarui.'
        );
}

    /**
     * Delete visit.
     */
    public function destroy(int $id)
    {
        $visit = $this->visitRepository->findById($id);

        if (!$visit) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Hanya Admin yang boleh delete.
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $this->visitService->delete($visit);

        return redirect()
            ->route('visits.index')
            ->with(
                'success',
                'Laporan kunjungan berhasil dihapus.'
            );
    }

    /**
     * Authorization visit.
     */
    private function authorizeVisit(Visit $visit): void
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Admin boleh melihat semua.
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Sales hanya boleh mengakses visit miliknya.
        |--------------------------------------------------------------------------
        */

        if ($visit->user_id !== $user->id) {
            abort(403);
        }
    }

}
