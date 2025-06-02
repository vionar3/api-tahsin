<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\QuizAnswer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function getQuizByMateri($materiId)
    {
        // Mengambil 5 soal secara acak dari materi tertentu
        $quizzes = Quiz::where('id_materi', $materiId)
                       ->inRandomOrder()
                       ->limit(5) // Hanya ambil 5 soal
                       ->get();

        if ($quizzes->isEmpty()) {
            return ResponseFormatter::error(
                null, 
                'Quiz tidak ditemukan untuk materi ini', 
                404
            );
        }

        return ResponseFormatter::success(
            $quizzes, 
            'Data quiz berhasil ditemukan'
        );
    }

public function checkAnswers(Request $request, $materiId)
{
    try {
        Log::info('Authenticated User ID: ' . Auth::id());

        // Validasi input
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:quiz,id',
            'answers.*.selected_option' => 'required|in:a,b,c,d',
        ]);

        $totalScore = 0;
        $correctAnswers = 0;

        foreach ($request->answers as $answer) {
            $quiz = Quiz::find($answer['question_id']);

            if ($quiz->correct_option === $answer['selected_option']) {
                $totalScore += $quiz->score;
                $correctAnswers++;
            }

            QuizAnswer::create([
                'id_quiz' => $answer['question_id'],
                'id_user' => Auth::id(), // Make sure this returns the correct user ID
                'selected_option' => $answer['selected_option'],
                'status' => $quiz->correct_option === $answer['selected_option'] ? 'correct' : 'incorrect',
            ]);
        }

        $quizResult = QuizResult::create([
            'id_user' => Auth::id(),
            'id_materi' => $materiId,
            'total_score' => $totalScore,
            'status' => 'selesai',
        ]);

        return ResponseFormatter::success(
            ['total_score' => $totalScore, 'correct_answers' => $correctAnswers],
            'Jawaban berhasil diperiksa dan hasil sudah dihitung'
        );
    } catch (Exception $error) {
        return ResponseFormatter::error(
            ['message' => 'Something went wrong', 'error' => $error->getMessage()],
            'Terjadi kesalahan', 500
        );
    }
}

public function getQuizResult(Request $request, $materiId)
    {
        try {
            // Ambil id_user dari token autentikasi
            $userId = Auth::id();

            // Ambil hasil quiz terakhir untuk user dan materi tersebut
            $quizResult = QuizResult::where('id_user', $userId)
                ->where('id_materi', $materiId)
                ->latest()  // Mengambil hasil terbaru
                ->first();

            // Jika tidak ada hasil untuk user dan materi ini, return dengan nilai default
            if (!$quizResult) {
                return ResponseFormatter::success([
                    'total_score' => 0,
                    'status' => 'belum selesai',
                ], 'Hasil Quiz Tidak Ditemukan');
            }

            // Jika ada hasil, kembalikan data hasil quiz
            return ResponseFormatter::success([
                'total_score' => $quizResult->total_score,
                'status' => $quizResult->status,
            ], 'Hasil Quiz Ditemukan');
        } catch (Exception $error) {
            return ResponseFormatter::error(
                ['message' => 'Something went wrong', 'error' => $error->getMessage()],
                'Terjadi Kesalahan', 500
            );
        }
    }


}
