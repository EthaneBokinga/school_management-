<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['nom_classe' => '6ème A', 'niveau' => '6ème', 'frais_scolarite' => 150000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => '6ème B', 'niveau' => '6ème', 'frais_scolarite' => 150000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => '5ème A', 'niveau' => '5ème', 'frais_scolarite' => 160000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => '5ème B', 'niveau' => '5ème', 'frais_scolarite' => 160000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => '4ème A', 'niveau' => '4ème', 'frais_scolarite' => 170000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => '4ème B', 'niveau' => '4ème', 'frais_scolarite' => 170000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => '3ème A', 'niveau' => '3ème', 'frais_scolarite' => 180000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => '3ème B', 'niveau' => '3ème', 'frais_scolarite' => 180000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => 'Seconde A', 'niveau' => 'Seconde', 'frais_scolarite' => 200000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => 'Seconde B', 'niveau' => 'Seconde', 'frais_scolarite' => 200000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => 'Première A', 'niveau' => 'Première', 'frais_scolarite' => 220000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => 'Première B', 'niveau' => 'Première', 'frais_scolarite' => 220000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => 'Terminale A', 'niveau' => 'Terminale', 'frais_scolarite' => 250000, 'created_at' => now(), 'updated_at' => now()],
            ['nom_classe' => 'Terminale B', 'niveau' => 'Terminale', 'frais_scolarite' => 250000, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('classes')->insert($classes);
    }
}
