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
        Schema::table('perikanan', function (Blueprint $table) {
            //
            $table->integer('musim_panen')->nullable()->after('jumlah_ikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perikanan', function (Blueprint $table) {
            //
            $table->dropColumn('musim_panen');
        });
    }
};
