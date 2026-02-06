<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TypeExamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $types = [
            ['libelle' => 'Contrôle Continu', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Devoir Surveillé', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Examen Semestriel', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Examen Final', 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Note de Participation', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('types_examens')->insert($types);
    }
}
