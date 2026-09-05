<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Visit;
use App\Models\Institution;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    /**
     * Total seluruh kunjungan.
     */
  public function getTotalVisits(
    ?int $userId = null,
    bool $isAdmin = false
): int {

    $query = Visit::query();

    if (!$isAdmin && $userId !== null) {

        $query->where(
            'user_id',
            $userId
        );

    }

    return $query->count();
}

    /**
     * Total kunjungan hari ini.
     */
   public function getTodayVisits(
    ?int $userId = null,
    bool $isAdmin = false
): int {

    $query = Visit::query()
        ->whereDate(
            'visit_date',
            today()
        );

    if (!$isAdmin && $userId !== null) {

        $query->where(
            'user_id',
            $userId
        );

    }

    return $query->count();
}

    /**
     * Total sales.
     */
    public function getTotalSales(): int
    {
        return User::where(
            'role',
            'sales'
        )->count();
    }

    /**
     * Total institusi.
     */
    public function getTotalInstitutions(): int
    {
        return Institution::count();
    }

    /**
     * Total berdasarkan hasil kunjungan.
     */
   public function getVisitResults(
    ?int $userId = null,
    bool $isAdmin = false
) {

    $query = Visit::query()
        ->select(
            'visit_result_id',
            DB::raw('COUNT(*) as total')
        )
        ->with('result');

    if (!$isAdmin && $userId !== null) {

        $query->where(
            'user_id',
            $userId
        );

    }

    return $query
        ->groupBy('visit_result_id')
        ->get();
}

    /**
     * Total kunjungan berdasarkan sales.
     */
   public function getVisitsBySales(
    ?int $userId = null,
    bool $isAdmin = false
) {

    $query = Visit::query()
        ->select(
            'user_id',
            DB::raw('COUNT(*) as total')
        )
        ->with('sales');

    if (!$isAdmin && $userId !== null) {

        $query->where(
            'user_id',
            $userId
        );

    }

    return $query
        ->groupBy('user_id')
        ->orderByDesc('total')
        ->get();
}


public function getRecentVisits(
    ?int $userId = null,
    bool $isAdmin = false,
    int $limit = 5
) {
    $query = Visit::query()
        ->with([
            'sales',
            'institution',
            'type',
            'result'
        ]);

    if (!$isAdmin && $userId !== null) {
        $query->where('user_id', $userId);
    }

    return $query
        ->orderByDesc('visit_date')
        ->orderByDesc('visit_time')
        ->limit($limit)
        ->get();
}


public function getVisitsLast7Days(
    ?int $userId = null,
    bool $isAdmin = false
): array {
    $result = [];

    for ($i = 6; $i >= 0; $i--) {

        $date = now()->subDays($i);

        $query = Visit::query()
            ->whereDate('visit_date', $date);

        if (!$isAdmin && $userId !== null) {
            $query->where('user_id', $userId);
        }

        $result[] = [
            'date' => $date->format('d/m'),
            'day' => $date->translatedFormat('D'),
            'total' => $query->count(),
        ];
    }

    return $result;
}

public function getVisitResultSummary(?int $userId = null, bool $isAdmin = false)
{
    $query = Visit::query()
        ->select(
            'visit_result_id',
            DB::raw('COUNT(*) as total')
        )
        ->with('result')
        ->groupBy('visit_result_id')
        ->orderByDesc('total');

    if (!$isAdmin && $userId !== null) {
        $query->where('user_id', $userId);
    }

    $results = $query->get();

    $total = $results->sum('total');

    return $results->map(function ($item) use ($total) {
        $item->percentage = $total > 0
            ? round(($item->total / $total) * 100, 1)
            : 0;

        return $item;
    });
}

public function getThisMonthVisits(?int $userId = null, bool $isAdmin = false): int
{
    $query = Visit::query()
        ->whereMonth('visit_date', now()->month)
        ->whereYear('visit_date', now()->year);

    if (!$isAdmin && $userId !== null) {
        $query->where('user_id', $userId);
    }

    return $query->count();
}

public function getLastMonthVisits(?int $userId = null, bool $isAdmin = false): int
{
    $lastMonth = now()->subMonth();

    $query = Visit::query()
        ->whereMonth('visit_date', $lastMonth->month)
        ->whereYear('visit_date', $lastMonth->year);

    if (!$isAdmin && $userId !== null) {
        $query->where('user_id', $userId);
    }

    return $query->count();
}


}