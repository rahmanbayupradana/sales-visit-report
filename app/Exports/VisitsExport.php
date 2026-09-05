<?php

namespace App\Exports;

use App\Repositories\VisitRepository;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VisitsExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    private array $filters;
    private ?int $userId;
    private bool $isAdmin;
    private VisitRepository $visitRepository;

    public function __construct(
        array $filters,
        ?int $userId,
        bool $isAdmin,
        VisitRepository $visitRepository
    ) {
        $this->filters = $filters;
        $this->userId = $userId;
        $this->isAdmin = $isAdmin;
        $this->visitRepository = $visitRepository;
    }

    public function query(): Builder
    {
        return $this->visitRepository->getFilteredQuery(
            $this->filters,
            $this->userId,
            $this->isAdmin
        );
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jam',
            'Sales',
            'Instansi',
            'PIC',
            'No. Telepon',
            'Jenis Kunjungan',
            'Hasil Kunjungan',
            'Catatan',
        ];
    }

    public function map($visit): array
    {
        static $number = 0;
        $number++;

        return [
            $number,
            $visit->visit_date
                ? $visit->visit_date->format('d/m/Y')
                : '-',
            $visit->visit_time ?? '-',
            $visit->sales->name ?? '-',
            $visit->institution->name ?? '-',
            $visit->institution->pic_name ?? '-',
            $visit->institution->phone ?? '-',
            $visit->type->name ?? '-',
            $visit->result->name ?? '-',
            $visit->notes ?? '-',
        ];
    }
}