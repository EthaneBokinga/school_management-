<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Année active (ID = 2)
        $inscriptions = [
            // 6ème A
            ['etudiant_id' => 1, 'classe_id' => 1, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 2, 'classe_id' => 1, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'Partiel', 'created_at' => now(), 'updated_at' => now()],
            
            // 6ème B
            ['etudiant_id' => 3, 'classe_id' => 2, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'En attente', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 4, 'classe_id' => 2, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            
            // 5ème A
            ['etudiant_id' => 5, 'classe_id' => 3, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 6, 'classe_id' => 3, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Partiel', 'created_at' => now(), 'updated_at' => now()],
            
            // 5ème B
            ['etudiant_id' => 7, 'classe_id' => 4, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 8, 'classe_id' => 4, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'En attente', 'created_at' => now(), 'updated_at' => now()],
            
            // 4ème A
            ['etudiant_id' => 9, 'classe_id' => 5, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 10, 'classe_id' => 5, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Partiel', 'created_at' => now(), 'updated_at' => now()],
            
            // 4ème B
            ['etudiant_id' => 11, 'classe_id' => 6, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 12, 'classe_id' => 6, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'En attente', 'created_at' => now(), 'updated_at' => now()],
            
            // 3ème A
            ['etudiant_id' => 13, 'classe_id' => 7, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 14, 'classe_id' => 7, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Partiel', 'created_at' => now(), 'updated_at' => now()],
            
            // Seconde A
            ['etudiant_id' => 15, 'classe_id' => 9, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 16, 'classe_id' => 9, 'annee_id' => 2, 'type_inscription' => 'Nouvelle', 'statut_paiement' => 'Partiel', 'created_at' => now(), 'updated_at' => now()],
            
            // Première A
            ['etudiant_id' => 17, 'classe_id' => 11, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 18, 'classe_id' => 11, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'En attente', 'created_at' => now(), 'updated_at' => now()],
            
            // Terminale A
            ['etudiant_id' => 19, 'classe_id' => 13, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Réglé', 'created_at' => now(), 'updated_at' => now()],
            ['etudiant_id' => 20, 'classe_id' => 13, 'annee_id' => 2, 'type_inscription' => 'Réinscription', 'statut_paiement' => 'Partiel', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('inscriptions')->insert($inscriptions);
    }
}
