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
        Schema::table('kas_masuks', function (Blueprint $table) {
            $table->foreignId('pembayaran_kas_id')->nullable()->constrained('pembayaran_kas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas_masuks', function (Blueprint $table) {
            $table->dropForeign(['pembayaran_kas_id']);
            $table->dropColumn('pembayaran_kas_id');
        });
    }
};
