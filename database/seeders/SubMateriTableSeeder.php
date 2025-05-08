<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubMateri;

class SubMateriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubMateri::create([
            'id_kategori' => 1, // Mengacu pada kategori "Rongga Mulut"
            'title' => 'Mad',
            'subtitle' => 'rongga mulut',
            'video_url' => 'https://youtu.be/qF_HuLMI-B4?si=IJWIzHu-vQXBaKgD',
            'intro' => 'Pengenalan rongga mulut',
        ]);

        SubMateri::create([
            'id_kategori' => 2, // Mengacu pada kategori "Tenggorokan"
            'title' => 'Hamzah',
            'subtitle' => 'Pangkal Tenggorokan',
            'video_url' => 'https://youtu.be/qF_HuLMI-B4?si=IJWIzHu-vQXBaKgD',
            'intro' => 'Penjelasan tentang pangkaltenggorokan',
        ]);
        SubMateri::create([
            'id_kategori' => 3, // Mengacu pada kategori "Rongga Mulut"
            'title' => 'Hamz vs Jahr',
            'subtitle' => 'Keluar nafas vs tidak keluar nafas',
            'video_url' => 'https://youtu.be/qF_HuLMI-B4?si=IJWIzHu-vQXBaKgD',
            'intro' => 'Pengenalan sifat hams dan jahr',
        ]);

        SubMateri::create([
            'id_kategori' => 4, // Mengacu pada kategori "Tenggorokan"
            'title' => 'Qalqalah',
            'subtitle' => 'Suara memantul',
            'video_url' => 'https://youtu.be/qF_HuLMI-B4?si=IJWIzHu-vQXBaKgD',
            'intro' => 'Penjelasan tentang qalqalah',
        ]);
        
    }
}
