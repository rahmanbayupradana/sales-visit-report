<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $institutions = [
            [
                'name' => 'TK Fajar Jaya',
                'pic_name' => 'Budi Santoso',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10',
            ],
            [
                'name' => 'TK Indriyasa VII',
                'pic_name' => 'Siti Aminah',
                'phone' => '081234567891',
                'address' => 'Jl. Pendidikan No. 20',
            ],
            [
                'name' => 'SD Hidayatul Mustaqim',
                'pic_name' => 'Ahmad Fauzi',
                'phone' => '081234567892',
                'address' => 'Jl. Melati No. 5',
            ],
            [
                'name' => 'SDK Indriyasa VII',
                'pic_name' => 'Dewi Lestari',
                'phone' => '081234567893',
                'address' => 'Jl. Mawar No. 15',
            ],
            [
                'name' => 'KB TK Dharma Mulia',
                'pic_name' => 'Rina Wulandari',
                'phone' => '081234567894',
                'address' => 'Jl. Sudirman No. 8',
            ],
            [
                'name' => 'RA Aulia',
                'pic_name' => 'Nur Hasanah',
                'phone' => '081234567895',
                'address' => 'Jl. Ahmad Yani No. 12',
            ],
        ];

        foreach ($institutions as $institution) {
            Institution::create($institution);
        }
    }
}
