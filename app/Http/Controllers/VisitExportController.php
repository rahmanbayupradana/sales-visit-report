<?php

namespace App\Http\Controllers;

use App\Exports\VisitsExport;
use App\Repositories\VisitRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VisitExportController extends Controller
{
    private VisitRepository $visitRepository;

    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    private function getFilters(Request $request): array
    {
        return [
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
    }

    public function excel(Request $request)
    {
        $user = auth()->user();

        $filters = $this->getFilters($request);

        return Excel::download(
            new VisitsExport(
                $filters,
                $user->id,
                $user->role === 'admin',
                $this->visitRepository
            ),
            'laporan-kunjungan.xlsx'
        );
    }

    public function pdf(Request $request)
    {
        $user = auth()->user();

        $filters = $this->getFilters($request);

        $visits = $this->visitRepository
            ->getFilteredQuery(
                $filters,
                $user->id,
                $user->role === 'admin'
            )
            ->get();

        $pdf = Pdf::loadView(
            'pdf.visits',
            compact('visits')
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-kunjungan.pdf'
        );
    }
}