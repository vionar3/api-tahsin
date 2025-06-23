<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sub_materi_id', 'status', 'nilai','id_latihan',];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke SubMateri
    public function subMateri()
    {
        return $this->belongsTo(SubMateri::class);
    }

    // Relasi ke Latihan
    public function Latihan()
    {
        return $this->belongsTo(Latihan::class, 'id_latihan');
    }
}
