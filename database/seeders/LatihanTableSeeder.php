<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Latihan;

class LatihanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Latihan::create([
            'id_submateri' => 1, // Mengacu pada sub materi "Makhrijul Huruf"
            'potongan_ayat' => 'بَسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ',
            'latin_text' => 'Bismillah',
            'materi_description' => 'Latihan pengucapan huruf',
            'correct_audio' => 'audio1.mp3',
            'recorder_audio' => 'user1',
        ]);

        Latihan::create([
            'id_submateri' => 2, // Mengacu pada sub materi "Tenggorokan"
            'potongan_ayat' => 'اَلْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ',
            'latin_text' => 'Alhamdulillah',
            'materi_description' => 'Latihan pengucapan huruf',
            'correct_audio' => 'audio2.mp3',
            'recorder_audio' => 'user2',
        ]);
        Latihan::create([
            'id_submateri' => 3, // Mengacu pada sub materi "Makhrijul Huruf"
            'potongan_ayat' => 'بَسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ',
            'latin_text' => 'Bismillah',
            'materi_description' => 'Latihan pengucapan huruf',
            'correct_audio' => 'audio1.mp3',
            'recorder_audio' => 'user1',
        ]);

        Latihan::create([
            'id_submateri' => 4, // Mengacu pada sub materi "Tenggorokan"
            'potongan_ayat' => 'اَلْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ',
            'latin_text' => 'Alhamdulillah',
            'materi_description' => 'Latihan pengucapan huruf',
            'correct_audio' => 'audio2.mp3',
            'recorder_audio' => 'user2',
        ]);
    }
}
