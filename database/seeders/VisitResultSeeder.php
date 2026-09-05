<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisitResult;
class VisitResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $results = [
            [
                'name' => 'PENAWARAN (BERTEMU PIC)',
                'description' => 'Sales bertemu langsung dengan PIC',
            ],
            [
                'name' => 'PENAWARAN (TIDAK BERTEMU PIC)',
                'description' => 'Sales datang tetapi tidak bertemu PIC',
            ],
            [
                'name' => 'FOLLOW UP',
                'description' => 'Membutuhkan follow up',
            ],
            [
                'name' => 'DEAL',
                'description' => 'Berhasil mendapatkan deal',
            ],
            [
                'name' => 'TIDAK BERMINAT',
                'description' => 'Instansi tidak berminat',
            ],
        ];

        foreach ($results as $result) {
            VisitResult::create($result);
        }
    }
}
