<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

     protected $table = 'quiz';

    // Menentukan field yang dapat diisi (fillable)
    protected $fillable = [
        'id_materi',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'score',
        'status',
    ];

    // Relasi dengan tabel materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }

    // Relasi dengan tabel quiz_answers (jawaban pengguna)
    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class, 'id_quiz');
    }
}
