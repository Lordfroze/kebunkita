<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perikanan', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('keuangan', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('gudang', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('toko', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('mutasi', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('perikanan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('gudang', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('toko', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('mutasi', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
