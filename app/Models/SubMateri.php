<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMateri extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'sub_materi';

    // Tentukan kolom yang bisa diisi (Mass Assignment)
    protected $fillable = [
        'id_kategori',
        'title',
        'subtitle',
        'video_url',
        'intro',
    ];

    // Relasi dengan latihan
    public function latihan()
    {
        return $this->hasMany(Latihan::class);
    }
}
