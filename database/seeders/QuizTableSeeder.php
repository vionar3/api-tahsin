<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            // Soal 1
            [
                'id_materi' => 1,
                'question' => 'Makharijul Huruf artinya .....',
                'option_a' => 'Tempat-tempat keluarnya huruf hijaiah',
                'option_b' => 'Tempat-tempat berubahnya huruf hijaiah',
                'option_c' => 'Tempat-tempat hilangnya huruf hijaiah',
                'option_d' => 'Tempat-tempat berkumpulnya huruf hijaiah',
                'correct_option' => 'a',
                'score' => 20,
            ],
            // Soal 2
            [
                'id_materi' => 1,
                'question' => 'Jumlah makhraj-makhraj huruf menurut Ibnu Jazari adalah .....',
                'option_a' => '15 makhraj',
                'option_b' => '16 makhraj',
                'option_c' => '17 makhraj',
                'option_d' => '18 makhraj',
                'correct_option' => 'c',
                'score' => 20,
            ],
            // Soal 3
            [
                'id_materi' => 1,
                'question' => 'Salah satu tempat keluarnya huruf adalah Al-Halqi. Halqi artinya .....',
                'option_a' => 'Lidah',
                'option_b' => 'Tenggorokan',
                'option_c' => 'Rongga hidung',
                'option_d' => 'Bibir',
                'correct_option' => 'b',
                'score' => 20,
            ],
            // Soal 4
            [
                'id_materi' => 1,
                'question' => 'Huruf ain (ع) merupakan huruf yang keluar dari .....',
                'option_a' => 'Lidah bagian tengah',
                'option_b' => 'Tenggorokan bagian tengah',
                'option_c' => 'Lidah bagian ujung',
                'option_d' => 'Tenggorokan bagian atas',
                'correct_option' => 'b',
                'score' => 20,
            ],
            // Soal 5
            [
                'id_materi' => 1,
                'question' => 'Jumlah huruf yang keluar lewat tenggorokan adalah .....',
                'option_a' => '5 huruf',
                'option_b' => '6 huruf',
                'option_c' => '7 huruf',
                'option_d' => '8 huruf',
                'correct_option' => 'b',
                'score' => 20,
            ],
            // Soal 6
            [
                'id_materi' => 1,
                'question' => 'Berikut ini merupakan huruf yang keluar lewat tenggorokan, kecuali .....',
                'option_a' => 'Huruf ghain (غ)',
                'option_b' => 'Huruf hamzah (ء)',
                'option_c' => 'Huruf kha (خ)',
                'option_d' => 'Huruf nun (ن)',
                'correct_option' => 'd',
                'score' => 20,
            ],
            // Soal 7
            [
                'id_materi' => 1,
                'question' => 'Berikut ini merupakan huruf yang memiliki makhraj sama dengan huruf jim (ج) adalah .....',
                'option_a' => 'Huruf syin (ش)',
                'option_b' => 'Huruf fa (ف)',
                'option_c' => 'Huruf lam (ل)',
                'option_d' => 'Huruf nun (ن)',
                'correct_option' => 'a',
                'score' => 20,
            ],
            // Soal 8
            [
                'id_materi' => 1,
                'question' => 'Huruf qaf (ق) merupakan huruf yang keluar dari lidah bagian ....',
                'option_a' => 'Pangkal lidah',
                'option_b' => 'Ujung lidah',
                'option_c' => 'Tengah lidah',
                'option_d' => 'Tepi lidah',
                'correct_option' => 'a',
                'score' => 20,
            ],
            // Soal 9
            [
                'id_materi' => 1,
                'question' => 'Jumlah huruf yang keluar lewat lidah adalah .....',
                'option_a' => '15 huruf',
                'option_b' => '16 huruf',
                'option_c' => '17 huruf',
                'option_d' => '18 huruf',
                'correct_option' => 'd',
                'score' => 20,
            ],
            // Soal 10
            [
                'id_materi' => 1,
                'question' => 'Jumlah huruf yang keluar lewat bibir adalah .....',
                'option_a' => '2 huruf',
                'option_b' => '3 huruf',
                'option_c' => '4 huruf',
                'option_d' => '5 huruf',
                'correct_option' => 'c',
                'score' => 20,
            ],
            // Soal 11
            [
                'id_materi' => 1,
                'question' => 'Berikut ini merupakan kelompok huruf yang keluar dari makhraj yang sama, kecuali .....',
                'option_a' => 'Huruf ع dan ح',
                'option_b' => 'Huruf غ dan خ',
                'option_c' => 'Huruf ل dan ط',
                'option_d' => 'Huruf ث, ذ, dan ظ',
                'correct_option' => 'a',
                'score' => 20,
            ],
            // Soal 12
            [
                'id_materi' => 1,
                'question' => 'Berikut ini merupakan huruf yang keluar dari pangkal lidah adalah .....',
                'option_a' => 'Huruf kaf (ك)',
                'option_b' => 'Huruf nun (ن)',
                'option_c' => 'Huruf jim (ج)',
                'option_d' => 'Huruf shad (ص)',
                'correct_option' => 'a',
                'score' => 20,
            ],
            // Soal 13
            [
                'id_materi' => 1,
                'question' => 'Berikut ini merupakan huruf yang keluar dari tengah lidah adalah .....',
                'option_a' => 'Huruf kaf (ك)',
                'option_b' => 'Huruf nun (ن)',
                'option_c' => 'Huruf jim (ج)',
                'option_d' => 'Huruf shad (ص)',
                'correct_option' => 'c',
                'score' => 20,
            ],
            // Soal 14
            [
                'id_materi' => 1,
                'question' => 'Huruf dhad (ض) merupakan huruf yang keluar dari .....',
                'option_a' => 'Pangkal lidah',
                'option_b' => 'Bibir dalam',
                'option_c' => 'Tepi lidah',
                'option_d' => 'Ujung lidah',
                'correct_option' => 'c',
                'score' => 20,
            ],
            // Soal 15
            [
                'id_materi' => 1,
                'question' => 'Dua huruf yang keluar dari makhraj yang sama disebut .....',
                'option_a' => 'Mutamatsilain',
                'option_b' => 'Mutajanisain',
                'option_c' => 'Mutaqaribain',
                'option_d' => 'Mutabaidain',
                'correct_option' => 'c',
                'score' => 20,
            ],
            // Soal 16
            [
                'id_materi' => 1,
                'question' => 'Berikut ini adalah huruf-huruf yang keluar dari ujung lidah, kecuali .....',
                'option_a' => 'Huruf dal (د)',
                'option_b' => 'Huruf tsa (ث)',
                'option_c' => 'Huruf ya (ي)',
                'option_d' => 'Huruf dha (ظ)',
                'correct_option' => 'c',
                'score' => 20,
            ],
            // Soal 17
            [
                'id_materi' => 1,
                'question' => 'Huruf yang keluar dari al-Jauf adalah .....',
                'option_a' => 'Alif',
                'option_b' => 'Ba',
                'option_c' => 'Ta',
                'option_d' => 'Tsa',
                'correct_option' => 'a',
                'score' => 20,
            ],
            // Soal 18
            [
                'id_materi' => 1,
                'question' => 'Berapa jumlah huruf yang keluar dari pangkal lidah? .....',
                'option_a' => '1 huruf',
                'option_b' => '2 huruf',
                'option_c' => '3 huruf',
                'option_d' => '4 huruf',
                'correct_option' => 'b',
                'score' => 20,
            ],
            // Soal 19
            [
                'id_materi' => 1,
                'question' => 'Berikut ini manakah pernyataan yang benar? .....',
                'option_a' => 'Makhraj sin (س) adalah ujung lidah dengan rongga antara gigi atas dan gigi bawah yang lebih dekat dengan gigi bawah',
                'option_b' => 'Makhraj ta (ت) adalah ujung lidah menempel dengan ujung gigi atas',
                'option_c' => 'Makhraj tha (ط) adalah ujung lidah menempel dengan ujung gigi atas',
                'option_d' => 'Makhraj tsa (ث) adalah ujung lidah dengan rongga antara gigi atas dan gigi bawah yang lebih dekat dengan gigi bawah',
                'correct_option' => 'b',
                'score' => 20,
            ],
            // Soal 20
            [
                'id_materi' => 1,
                'question' => 'Makhraj huruf zay (ز) adalah .....',
                'option_a' => 'Ujung lidah dengan rongga antara gigi atas dan gigi bawah yang lebih dekat dengan gigi bawah',
                'option_b' => 'Ujung lidah menempel dengan pangkal gigi atas',
                'option_c' => 'Ujung lidah menempel dengan ujung gigi atas',
                'option_d' => 'Tenggorakan bagian tengah',
                'correct_option' => 'c',
                'score' => 20,
            ],
        ];

        // Insert data soal ke dalam tabel quiz
        foreach ($questions as $question) {
            DB::table('quiz')->insert([
                'id_materi' => $question['id_materi'],
                'question' => $question['question'],
                'option_a' => $question['option_a'],
                'option_b' => $question['option_b'],
                'option_c' => $question['option_c'],
                'option_d' => $question['option_d'],
                'correct_option' => $question['correct_option'],
                'score' => $question['score'],
                'status' => 'unanswered',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
