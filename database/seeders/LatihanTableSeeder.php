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

    // Data kedua
    Latihan::create([
        'id_submateri' => 1, // Mengacu pada sub materi "Makhrijul Huruf"
        'potongan_ayat' => 'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ',
        'latin_text' => 'Alhamdulillah Rabbil Alamin',
        'materi_description' => 'Latihan pengucapan huruf dengan panjang',
        'correct_audio' => 'audio2.mp3',
        'recorder_audio' => 'user2',
    ]);

    // Data ketiga
    Latihan::create([
        'id_submateri' => 1, // Mengacu pada sub materi "Makhrijul Huruf"
        'potongan_ayat' => 'الرَّحْمَنِ الرَّحِيمِ',
        'latin_text' => 'Ar-Rahman Ar-Rahim',
        'materi_description' => 'Latihan pengucapan huruf dengan tajwid',
        'correct_audio' => 'audio3.mp3',
        'recorder_audio' => 'user3',
    ]);

    // Data keempat
    Latihan::create([
        'id_submateri' => 1, // Mengacu pada sub materi "Makhrijul Huruf"
        'potongan_ayat' => 'مَالِكِ يَوْمِ الدِّينِ',
        'latin_text' => 'Maliki Yawmiddin',
        'materi_description' => 'Latihan pengucapan huruf yang benar',
        'correct_audio' => 'audio4.mp3',
        'recorder_audio' => 'user4',
    ]);
    }
}
