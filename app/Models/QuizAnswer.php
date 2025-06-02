<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $table = 'quiz_answers';

    // Menentukan field yang dapat diisi (fillable)
    protected $fillable = [
        'id_quiz',
        'id_user',
        'selected_option',
        'status',
    ];

    // Relasi dengan tabel quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }

    // Relasi dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
