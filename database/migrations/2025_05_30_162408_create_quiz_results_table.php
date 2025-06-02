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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();  // Auto increment primary key
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Mengacu ke tabel users
            $table->foreignId('id_materi')->constrained('materi')->onDelete('cascade'); // Mengacu ke tabel materi
            $table->integer('total_score');  // Skor total yang didapat pengguna
            $table->enum('status', ['selesai', 'belum selesai'])->default('belum selesai');  // Status penyelesaian quiz
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
