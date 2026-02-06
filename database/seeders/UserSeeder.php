<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Administrateur',
            'email' => 'admin@school.cg',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'reference_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

         // Professeurs (référence aux enseignants)
        for ($i = 1; $i <= 10; $i++) {
            $enseignant = DB::table('enseignants')->find($i);
            DB::table('users')->insert([
                'name' => $enseignant->prenom . ' ' . $enseignant->nom,
                'email' => $enseignant->email,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'reference_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Élèves (référence aux étudiants)
        for ($i = 1; $i <= 20; $i++) {
            $etudiant = DB::table('etudiants')->find($i);
            DB::table('users')->insert([
                'name' => $etudiant->prenom . ' ' . $etudiant->nom,
                'email' => strtolower($etudiant->matricule) . '@eleve.school.cg',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'reference_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
