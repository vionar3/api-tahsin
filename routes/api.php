<?php

use App\Http\Controllers\API\UserControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MateriControler;
use App\Http\Controllers\API\KategoryController;
use App\Http\Controllers\API\SubMateriControler;
use App\Http\Controllers\API\LatihanControler;
use App\Http\Controllers\QuizController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [UserControler::class, 'register']);
Route::post('login', [UserControler::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserControler::class, 'fetch']);
    Route::post('logout', [UserControler::class, 'logout']);
});

Route::get('/materi', [MateriControler::class, 'getMateri']);
Route::get('/kategori/{id_materi}', [KategoryController::class, 'getKategoriByMateri']);
// Route::get('/sub_materi', [SubMateriControler::class, 'getAllSubMateri']);
Route::get('/sub_materi/{id_kategori}', [SubMateriControler::class, 'getSubMateriByKategori']);
Route::get('/latihan/{id_submateri}', [LatihanControler::class, 'getLatihanBySubMateri']);
Route::get('quiz/{materiId}', [QuizController::class, 'getQuizByMateri']);
// Route::post('quiz/{materiId}/check', [QuizController::class, 'checkAnswers']);
Route::middleware('auth:sanctum')->group(function () {
    // Endpoint untuk memeriksa jawaban quiz
    Route::post('quiz/{materiId}/check', [QuizController::class, 'checkAnswers']);
    
    // Endpoint untuk mengambil hasil quiz berdasarkan materiId
    Route::get('quizresult/{materiId}', [QuizController::class, 'getQuizResult']);
});
Route::middleware('auth:sanctum')->group(function () {
    // Rute untuk mendapatkan user berdasarkan ID
    Route::get('/user/{id}', [UserControler::class, 'getUserInfoById']);
    
    // Rute untuk mendapatkan users berdasarkan peran (role) tertentu
    Route::get('users/santri', [UserControler::class, 'getUsersByRole']);

    Route::put('/updateUser/{id}', [UserControler::class, 'updateUserById']);

    Route::post('/tambahSantri', [UserControler::class, 'tambahSantri']);
});

