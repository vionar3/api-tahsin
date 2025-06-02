<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_materi', 'total_score', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }
}
