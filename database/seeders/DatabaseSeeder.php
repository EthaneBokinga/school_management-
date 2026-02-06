<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
            RoleSeeder::class,
            AnneeScolaireSeeder::class,
            SalleSeeder::class,
            ClasseSeeder::class,
            MatiereSeeder::class,
            TypeExamenSeeder::class,
            EnseignantSeeder::class,
            EtudiantSeeder::class,
            UserSeeder::class,
            InscriptionSeeder::class,
            CoursSeeder::class,
        ]);

    

    }
}
