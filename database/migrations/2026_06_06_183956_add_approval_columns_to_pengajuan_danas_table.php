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
        Schema::table('pengajuan_danas', function (Blueprint $table) {
            // Kita asumsikan kolom status sudah ada dari sebelumnya dan bertipe string. 
            // Jika belum memiliki default, kita buat defaultnya pending di aplikasi atau kita biarkan.
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('catatan_reviewer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_danas', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn(['reviewer_id', 'reviewed_at', 'catatan_reviewer']);
        });
    }
};
