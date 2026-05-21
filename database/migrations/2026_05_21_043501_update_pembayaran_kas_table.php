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
        Schema::table('pembayaran_kas', function (Blueprint $table) {
            $table->foreignId('tagihan_kas_id')->nullable()->constrained('tagihan_kas')->cascadeOnDelete();
            $table->string('bukti_pembayaran')->nullable()->change();
            $table->string('status')->default('Belum Bayar')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran_kas', function (Blueprint $table) {
            $table->dropForeign(['tagihan_kas_id']);
            $table->dropColumn('tagihan_kas_id');
            $table->string('bukti_pembayaran')->nullable(false)->change();
            $table->string('status')->default('Menunggu Verifikasi')->change();
        });
    }
};
