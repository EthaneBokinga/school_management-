<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $etudiants = [
            ['matricule' => 'ETU2024001', 'nom' => 'KONGO', 'prenom' => 'Albert', 'date_naissance' => '2010-03-15', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024002', 'nom' => 'LOEMBA', 'prenom' => 'Berthe', 'date_naissance' => '2010-07-22', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024003', 'nom' => 'NGOMA', 'prenom' => 'Charles', 'date_naissance' => '2011-01-10', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024004', 'nom' => 'BOUITY', 'prenom' => 'Divine', 'date_naissance' => '2011-05-18', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024005', 'nom' => 'ELENGA', 'prenom' => 'Emmanuel', 'date_naissance' => '2009-09-08', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024006', 'nom' => 'MASSAMBA', 'prenom' => 'Françoise', 'date_naissance' => '2009-11-25', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024007', 'nom' => 'BANZOUZI', 'prenom' => 'Georges', 'date_naissance' => '2010-02-14', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024008', 'nom' => 'IBARA', 'prenom' => 'Hélène', 'date_naissance' => '2010-06-30', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024009', 'nom' => 'MOUANDZA', 'prenom' => 'Isaac', 'date_naissance' => '2011-04-12', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024010', 'nom' => 'NGOUABI', 'prenom' => 'Joséphine', 'date_naissance' => '2011-08-20', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024011', 'nom' => 'LOUFOUA', 'prenom' => 'Kevin', 'date_naissance' => '2008-12-05', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024012', 'nom' => 'ITOUA', 'prenom' => 'Laurette', 'date_naissance' => '2008-10-17', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024013', 'nom' => 'TCHICAYA', 'prenom' => 'Martin', 'date_naissance' => '2009-03-22', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024014', 'nom' => 'ONDZOTTO', 'prenom' => 'Nicole', 'date_naissance' => '2009-07-09', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024015', 'nom' => 'MPIKA', 'prenom' => 'Olivier', 'date_naissance' => '2007-01-28', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024016', 'nom' => 'BIHONDA', 'prenom' => 'Patricia', 'date_naissance' => '2007-05-15', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024017', 'nom' => 'SAMBA', 'prenom' => 'Quentin', 'date_naissance' => '2008-09-11', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024018', 'nom' => 'MILANDOU', 'prenom' => 'Rose', 'date_naissance' => '2008-11-03', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024019', 'nom' => 'GOMA', 'prenom' => 'Samuel', 'date_naissance' => '2006-04-19', 'sexe' => 'M', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
            ['matricule' => 'ETU2024020', 'nom' => 'NGOUMA', 'prenom' => 'Thérèse', 'date_naissance' => '2006-08-27', 'sexe' => 'F', 'statut_actuel' => 'Inscrit', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('etudiants')->insert($etudiants);
    }
}
