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
       // Tabel Gudang
       Schema::create('gudang', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang')->unique();
        $table->string('nama_barang');
        $table->integer('stok')->default(0);
        $table->decimal('harga_modal', 10, 2);
        $table->decimal('harga_jual', 10, 2);
        $table->timestamps();
    });

    // Tabel Toko
    Schema::create('toko', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang')->unique();
        $table->string('nama_barang');
        $table->integer('stok')->default(0);
        $table->decimal('harga_jual', 10, 2);
        $table->timestamps();
    });

    // Tabel Mutasi
    Schema::create('mutasi', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang');
        $table->integer('jumlah');
        $table->timestamp('tanggal')->useCurrent();
        $table->foreign('kode_barang')->references('kode_barang')->on('gudang')->onUpdate('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi');
        Schema::dropIfExists('toko');
        Schema::dropIfExists('gudang');
    }
};
