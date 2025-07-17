<?php

use App\Http\Controllers\API\UserControler;
use App\Http\Controllers\API\ChangePassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MateriControler;
use App\Http\Controllers\API\UploadAudioController;
use App\Http\Controllers\API\KategoryController;
use App\Http\Controllers\API\SubMateriControler;
use App\Http\Controllers\API\LatihanControler;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\API\ProgressController;

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
Route::post('loginWithTelp', [UserControler::class, 'loginWithTelp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserControler::class, 'fetch']);
    Route::post('logout', [UserControler::class, 'logout']);
    Route::post('/change_password', [UserControler::class, 'changePassword']);
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

    Route::get('/userByToken', [UserControler::class, 'getUserInfoByToken']);

    // Memperbarui data pengguna berdasarkan token
    Route::post('/user/updateBytoken', [UserControler::class, 'updateUserByToken']);
    Route::post('/importSantri', [UserControler::class, 'importSantri']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/materi/{materiId}/progress', [ProgressController::class, 'getMateriProgress']);
    Route::post('/progress/{subMateriId}/update', [ProgressController::class, 'updateProgress']);
    Route::get('/progress/{subMateriId}/status', [ProgressController::class, 'getProgressBySubMateri']);
    Route::get('/progres/presentase', [ProgressController::class, 'getProgressPercentage']);
    Route::get('/progres/{user_id}', [ProgressController::class, 'getProgressPercentageById']);
    Route::put('latihan/{id_latihan}/saverecord', [ProgressController::class, 'saveRecordedAudioName']);
    // Route::post('progress/{submateri_id}/save', [ProgressController::class, 'saveProgress']);
    Route::get('/hasil-penilaian/{submateri_id}', [ProgressController::class, 'getHasilPenilaianByUserAndSubMateri']);
    // Route::post('/upload_audio', [UploadAudioController::class, 'uploadAudio']);
    Route::post('/upload_audio', [UploadAudioController::class, 'uploadAudio']);
    Route::post('/update_progress_status', [ProgressController::class, 'updateStatusBatch']);

    Route::get('/progress/menunggu', [ProgressController::class, 'progressMenunggu']);

    Route::get('/progress/latihan/{user_id}/{sub_materi_id}', [ProgressController::class, 'getProgressLatihanByUserAndSubmateri']);
    Route::post('save_penilaian', [ProgressController::class, 'savePenilaian']);


});



Route::get('/users/progres', [UserControler::class, 'getUserProgres']);

