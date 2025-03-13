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
        Schema::create('perikanan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('kegiatan');
            $table->string('lokasi');
            $table->string('biaya');
            $table->string('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perikanan');
    }
};
