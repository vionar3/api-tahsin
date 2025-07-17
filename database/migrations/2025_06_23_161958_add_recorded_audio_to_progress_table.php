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
            // Menambahkan kolom 'recorded_audio' dengan tipe data string
            $table->string('recorder_audio')->nullable(); // Anda bisa menyesuaikan tipe data sesuai kebutuhan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            // Menghapus kolom 'recorded_audio' jika rollback dilakukan
            $table->dropColumn('recorded_audio');
        });
    }
};
