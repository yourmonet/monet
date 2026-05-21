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
        Schema::create('pembayaran_kas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('periode'); // e.g. "2026-05"
            $table->integer('nominal');
            $table->string('bukti_pembayaran');
            $table->text('catatan')->nullable();
            $table->string('status')->default('Menunggu Verifikasi'); // Lunas, Menunggu Verifikasi, Ditolak, Belum Bayar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_kas');
    }
};
