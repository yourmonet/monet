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
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->text('approval_note')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
        });

        Schema::create('pengajuan_dana_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_dana_id')->constrained('pengajuan_danas')->cascadeOnDelete();
            $table->string('status_sebelum');
            $table->string('status_sesudah');
            $table->text('catatan')->nullable();
            $table->foreignId('approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_dana_histories');

        Schema::table('pengajuan_danas', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropColumn([
                'approved_by',
                'approved_at',
                'approval_note',
                'rejected_by',
                'rejected_at',
                'rejection_reason'
            ]);
        });
    }
};
