<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('kategori_transaksis', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kategori'); // Misal: "Konsumsi", "Danus", "Transportasi"
        $table->enum('jenis', ['pemasukan', 'pengeluaran']); // Untuk membedakan ini kategori uang masuk atau keluar
        $table->text('deskripsi')->nullable(); // Penjelasan singkat (opsional)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_transaksis');
    }
};
