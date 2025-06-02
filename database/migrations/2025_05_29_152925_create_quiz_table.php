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
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();  // ID primary key
            $table->foreignId('id_materi')->constrained('materi')->onDelete('cascade'); // Relasi ke materi
            $table->text('question');  // Soal quiz
            $table->string('option_a');  // Pilihan jawaban A
            $table->string('option_b');  // Pilihan jawaban B
            $table->string('option_c');  // Pilihan jawaban C
            $table->string('option_d');  // Pilihan jawaban D
            $table->char('correct_option', 1);  // Menyimpan jawaban yang benar (a, b, c, d)
            $table->integer('score');  // Skor soal
            $table->enum('status', ['answered', 'unanswered'])->default('unanswered');  // Status soal
            $table->timestamps();  // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
