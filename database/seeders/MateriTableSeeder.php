<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materi;

class MateriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            'title' => 'Makharijul Huruf',
            'subtitle' => 'Penjelasan tentang pengucapan huruf-huruf',
        ]);

        Materi::create([
            'title' => 'sifatul huruf',
            'subtitle' => 'sifat yang membedakan setiap huruf',
        ]);
    }
}
