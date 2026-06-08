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
            $table->text('alasan_penolakan')->nullable()->after('catatan');
        });

        Schema::create('pembayaran_kas_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_kas_id')->constrained('pembayaran_kas')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_kas_reminders');

        Schema::table('pembayaran_kas', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }
};
