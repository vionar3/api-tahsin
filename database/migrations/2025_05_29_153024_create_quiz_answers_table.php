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
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();  // ID primary key
            $table->foreignId('id_quiz')->constrained('quiz')->onDelete('cascade');  // Relasi ke tabel quiz
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');  // Relasi ke tabel users
            $table->char('selected_option', 1);  // Jawaban yang dipilih oleh pengguna (a, b, c, d)
            $table->enum('status', ['correct', 'incorrect']);  // Status jawaban (benar atau salah)
            $table->timestamps();  // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};
