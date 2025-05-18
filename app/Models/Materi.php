<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'materi';

    // Tentukan kolom yang bisa diisi (Mass Assignment)
    protected $fillable = [
        'title',
        'subtitle',
        'description',
    ];

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->hasMany(Kategori::class);
    }
}
