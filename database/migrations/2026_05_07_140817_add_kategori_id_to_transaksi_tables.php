<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Menyuntikkan kolom kategori_id ke tabel kas_masuks
        Schema::table('kas_masuks', function (Blueprint $table) {
            // Kita buat nullable() agar data lama yang sudah ada tidak error saat di-migrate
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_transaksis')->nullOnDelete();
        });

        // Menyuntikkan kolom kategori_id ke tabel kas_keluars
        Schema::table('kas_keluars', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_transaksis')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('kas_masuks', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });

        Schema::table('kas_keluars', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};