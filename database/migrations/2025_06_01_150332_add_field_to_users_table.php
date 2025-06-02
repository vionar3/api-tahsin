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
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
            $table->string('usia')->nullable(); // Menambahkan kolom 'usia' dengan tipe integer
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(); // Menambahkan kolom 'jenis_kelamin' dengan tipe enum (L = Laki-laki, P = Perempuan)
            $table->string('jenjang_pendidikan')->nullable(); // Menambahkan kolom 'jenjang_pendidikan' dengan tipe string
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['usia', 'jenis_kelamin', 'jenjang_pendidikan']);
        });
    }
};
