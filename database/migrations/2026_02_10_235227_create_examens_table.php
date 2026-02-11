<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->foreignId('type_examen_id')->constrained('types_examens')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_examen');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->foreignId('salle_id')->nullable()->constrained('salles')->onDelete('set null');
            $table->enum('statut', ['Programmé', 'En cours', 'Terminé'])->default('Programmé');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examens');
    }
};