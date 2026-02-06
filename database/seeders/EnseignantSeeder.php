<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EnseignantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enseignants = [
            ['nom' => 'MBEMBA', 'prenom' => 'Jean', 'specialite' => 'Mathématiques', 'email' => 'jean.mbemba@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'NKOUNKOU', 'prenom' => 'Marie', 'specialite' => 'Français', 'email' => 'marie.nkounkou@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'MABIALA', 'prenom' => 'Pierre', 'specialite' => 'Anglais', 'email' => 'pierre.mabiala@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAKALA', 'prenom' => 'Grace', 'specialite' => 'Physique-Chimie', 'email' => 'grace.bakala@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'OKONGO', 'prenom' => 'Daniel', 'specialite' => 'SVT', 'email' => 'daniel.okongo@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'MOUKOKO', 'prenom' => 'Christine', 'specialite' => 'Histoire-Géographie', 'email' => 'christine.moukoko@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'MALONGA', 'prenom' => 'Paul', 'specialite' => 'Philosophie', 'email' => 'paul.malonga@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'NSIKA', 'prenom' => 'Sophie', 'specialite' => 'EPS', 'email' => 'sophie.nsika@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'MAKITA', 'prenom' => 'David', 'specialite' => 'Informatique', 'email' => 'david.makita@school.cg', 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BOUESSO', 'prenom' => 'Ange', 'specialite' => 'Arts Plastiques', 'email' => 'ange.bouesso@school.cg', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('enseignants')->insert($enseignants);
    }
}
