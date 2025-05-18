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
            'id_kategori' => 2, // Mengacu pada kategori "Rongga Mulut"
            'title' => 'ain & ha',
            'subtitle' => 'tengah tenggorokan',
            'video_url' => 'https://youtu.be/qF_HuLMI-B4?si=IJWIzHu-vQXBaKgD',
            'intro' => 'Pengenalan rongga mulut',
        ]);

        SubMateri::create([
            'id_kategori' => 2, // Mengacu pada kategori "Tenggorokan"
            'title' => 'ghain & ha',
            'subtitle' => 'ujung tenggorokan',
            'video_url' => 'https://youtu.be/qF_HuLMI-B4?si=IJWIzHu-vQXBaKgD',
            'intro' => 'Penjelasan tentang pangkaltenggorokan',
        ]);
        
    }
}
