<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $salles = [
            ['nom_salle' => 'Salle A1', 'type' => 'Cours', 'created_at' => now(), 'updated_at' => now()],
            ['nom_salle' => 'Salle A2', 'type' => 'Cours', 'created_at' => now(), 'updated_at' => now()],
            ['nom_salle' => 'Salle B1', 'type' => 'Cours', 'created_at' => now(), 'updated_at' => now()],
            ['nom_salle' => 'Salle B2', 'type' => 'Cours', 'created_at' => now(), 'updated_at' => now()],
            ['nom_salle' => 'Labo Informatique', 'type' => 'Labo', 'created_at' => now(), 'updated_at' => now()],
            ['nom_salle' => 'Labo Sciences', 'type' => 'Labo', 'created_at' => now(), 'updated_at' => now()],
            ['nom_salle' => 'Gymnase', 'type' => 'Sport', 'created_at' => now(), 'updated_at' => now()],
            ['nom_salle' => 'Terrain de Sport', 'type' => 'Sport', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('salles')->insert($salles);
    }
}
