<?php

use App\Http\Controllers\API\UserControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
