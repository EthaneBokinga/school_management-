<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $roles = [
            ['nom_role' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['nom_role' => 'Prof', 'created_at' => now(), 'updated_at' => now()],
            ['nom_role' => 'Eleve', 'created_at' => now(), 'updated_at' => now()],
            ['nom_role' => 'Parent', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('roles')->insert($roles);
    }
}
