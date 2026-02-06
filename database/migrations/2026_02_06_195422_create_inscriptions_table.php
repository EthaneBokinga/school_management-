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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('classes');
            $table->foreignId('annee_id')->constrained('annees_scolaires');
            $table->timestamp('date_inscription')->useCurrent();
            $table->enum('type_inscription', ['Nouvelle', 'Réinscription'])->default('Nouvelle');
            $table->enum('statut_paiement', ['Réglé', 'Partiel', 'En attente'])->default('En attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
