<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 20)->unique();
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->date('date_naissance')->nullable();
            $table->enum('sexe', ['M', 'F']);
            $table->enum('statut_actuel', ['Inscrit', 'Diplomé', 'Quitté'])->default('Inscrit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
