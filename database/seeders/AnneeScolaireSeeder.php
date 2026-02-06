<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnneeScolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $annees = [
            [
                'libelle' => '2023-2024',
                'date_debut' => '2023-09-01',
                'date_fin' => '2024-06-30',
                'est_active' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'libelle' => '2024-2025',
                'date_debut' => '2024-09-01',
                'date_fin' => '2025-06-30',
                'est_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'libelle' => '2025-2026',
                'date_debut' => '2025-09-01',
                'date_fin' => '2026-06-30',
                'est_active' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('annees_scolaires')->insert($annees);
    }
}
