<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create([
            'id_materi' => 1, // Mengacu pada materi "Makharijul Huruf"
            'nama_kategori' => 'Rongga Mulut',
        ]);

        Kategori::create([
            'id_materi' => 1,
            'nama_kategori' => 'Tenggorokan',
        ]);
        Kategori::create([
            'id_materi' => 2, // Mengacu pada materi "Sifatul Huruf"
            'nama_kategori' => 'Memiliki lawan',
        ]);

        Kategori::create([
            'id_materi' => 2,
            'nama_kategori' => 'Tidak memiliki lawan',
        ]);
    }
}
