<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('echeances_paiement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscription_id')->constrained('inscriptions')->onDelete('cascade');
            $table->string('mois'); // Ex: Septembre 2024, Octobre 2024
            $table->decimal('montant_echeance', 10, 2);
            $table->date('date_limite');
            $table->enum('statut', ['En attente', 'Payé', 'En retard'])->default('En attente');
            $table->decimal('montant_paye', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('echeances_paiement');
    }
};