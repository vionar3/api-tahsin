<?php

use App\Http\Controllers\API\UserControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MateriControler;
use App\Http\Controllers\API\KategoryController;
use App\Http\Controllers\API\SubMateriControler;
use App\Http\Controllers\API\LatihanControler;

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
Route::get('/sub_materi/{id_kategori}', [SubMateriControler::class, 'getSubMateriByKategori']);
Route::get('/latihan/{id_submateri}', [LatihanControler::class, 'getLatihanBySubMateri']);