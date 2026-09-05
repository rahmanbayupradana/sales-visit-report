<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisitType;


class VisitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $types = [
            [
                'name' => 'Edu',
                'description' => 'Institusi pendidikan',
            ],
            [
                'name' => 'Corporate',
                'description' => 'Perusahaan',
            ],
            [
                'name' => 'Government',
                'description' => 'Instansi pemerintah',
            ],
            [
                'name' => 'Retail',
                'description' => 'Retail / toko',
            ],
            [
                'name' => 'Other',
                'description' => 'Kategori lainnya',
            ],
        ];

         foreach ($types as $type) {
            VisitType::create($type);
        }
    }
}
