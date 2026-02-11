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
        Schema::table('ressources_pedagogiques', function (Blueprint $table) {
            if (!Schema::hasColumn('ressources_pedagogiques', 'description')) {
                $table->text('description')->nullable()->after('titre');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ressources_pedagogiques', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
