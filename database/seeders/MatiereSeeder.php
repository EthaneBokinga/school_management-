<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $matieres = [
            ['nom_matiere' => 'Mathématiques', 'code_matiere' => 'MATH', 'coefficient' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'Français', 'code_matiere' => 'FR', 'coefficient' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'Anglais', 'code_matiere' => 'ANG', 'coefficient' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'Physique-Chimie', 'code_matiere' => 'PC', 'coefficient' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'SVT', 'code_matiere' => 'SVT', 'coefficient' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'Histoire-Géographie', 'code_matiere' => 'HISTGEO', 'coefficient' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'Philosophie', 'code_matiere' => 'PHILO', 'coefficient' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'EPS', 'code_matiere' => 'EPS', 'coefficient' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'Informatique', 'code_matiere' => 'INFO', 'coefficient' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nom_matiere' => 'Arts Plastiques', 'code_matiere' => 'ART', 'coefficient' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('matieres')->insert($matieres);
    }
}
