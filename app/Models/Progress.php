<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sub_materi_id', 'status', 'nilai','id_latihan','recorder_audio','status_validasi','feedback_pengajar','total_nilai',];

    // Relasi ke User
    public function user() {
    return $this->belongsTo(User::class, 'user_id');
}

    // Relasi ke SubMateri
    public function subMateri()
    {
        return $this->belongsTo(SubMateri::class,'sub_materi_id');
    }

    // Relasi ke Latihan
    public function Latihan()
    {
        return $this->belongsTo(Latihan::class, 'id_latihan');
    }
}
