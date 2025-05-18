<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'kategori';

    // Tentukan kolom yang bisa diisi (Mass Assignment)
    protected $fillable = [
        'id_materi',
        'nama_kategori',
    ];

    // Relasi dengan sub materi
    public function subMateri()
{
    return $this->hasMany(SubMateri::class, 'id_kategori');
}

}
