<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latihan extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'latihan';

    // Tentukan kolom yang bisa diisi (Mass Assignment)
    protected $fillable = [
        'id_submateri',
        'potongan_ayat',
        'latin_text',
        'materi_description',
        'correct_audio',
        'recorder_audio',
    ];

}
