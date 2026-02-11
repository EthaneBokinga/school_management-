<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ressources_pedagogiques', function (Blueprint $table) {
            $table->string('type_fichier')->nullable()->after('url_fichier'); // pdf, doc, ppt, etc.
            $table->bigInteger('taille_fichier')->nullable()->after('type_fichier'); // en bytes
        });
    }

    public function down(): void
    {
        Schema::table('ressources_pedagogiques', function (Blueprint $table) {
            $table->dropColumn(['type_fichier', 'taille_fichier']);
        });
    }
};