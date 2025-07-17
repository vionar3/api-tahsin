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
        Schema::table('latihan', function (Blueprint $table) {
            // Menghapus kolom 'recorded_audio'
            $table->dropColumn('recorder_audio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('latihan', function (Blueprint $table) {
            // Menambahkan kembali kolom 'recorded_audio' jika rollback dilakukan
            $table->string('recorder_audio')->nullable();
        });
    }
};
