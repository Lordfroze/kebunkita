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
            ////Menambah kolom active setelah kolom content
            $table->boolean('active')->default(true)->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perikanan', function (Blueprint $table) {
            // menghapus kolom active
            $table->dropColumn('active');
        });
    }
};
