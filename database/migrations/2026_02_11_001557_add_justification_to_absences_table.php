<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->text('motif_justification')->nullable()->after('est_justifie');
            $table->string('fichier_justificatif')->nullable()->after('motif_justification');
        });
    }

    public function down(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn(['motif_justification', 'fichier_justificatif']);
        });
    }
};