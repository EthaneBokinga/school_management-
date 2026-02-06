<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $cours = [
            // 6ème A
            ['enseignant_id' => 1, 'matiere_id' => 1, 'classe_id' => 1, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 2, 'matiere_id' => 2, 'classe_id' => 1, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 3, 'matiere_id' => 3, 'classe_id' => 1, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            
            // 5ème A
            ['enseignant_id' => 1, 'matiere_id' => 1, 'classe_id' => 3, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 2, 'matiere_id' => 2, 'classe_id' => 3, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 4, 'matiere_id' => 4, 'classe_id' => 3, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            
            // 4ème A
            ['enseignant_id' => 1, 'matiere_id' => 1, 'classe_id' => 5, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 2, 'matiere_id' => 2, 'classe_id' => 5, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 5, 'matiere_id' => 5, 'classe_id' => 5, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            
            // Terminale A
            ['enseignant_id' => 1, 'matiere_id' => 1, 'classe_id' => 13, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 7, 'matiere_id' => 7, 'classe_id' => 13, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['enseignant_id' => 4, 'matiere_id' => 4, 'classe_id' => 13, 'annee_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('cours')->insert($cours);
    }
}
