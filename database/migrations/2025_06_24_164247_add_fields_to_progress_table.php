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
        Schema::table('progress', function (Blueprint $table) {
            $table->enum('status_validasi', ['benar', 'salah'])->nullable(); // status_validasi field
            $table->text('feedback_pengajar')->nullable(); // feedback_pengajar field
            $table->integer('total_nilai')->nullable(); // total_nilai field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->dropColumn(['status_validasi', 'feedback_pengajar', 'total_nilai']);
        });
    }
};
