<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IsianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'indexlogin'])->middleware('IsStay');
Route::get('/login', [AuthController::class, 'indexlogin'])->middleware('IsStay');
Route::get('/register', [AuthController::class, 'indexregister'])->middleware('IsStay');

Route::post('/register', [AuthController::class, 'register'])->middleware('IsStay');
Route::post('/login', [AuthController::class, 'login'])->middleware('IsStay');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('IsLogin');


Route::post('/updateprofil', [AuthController::class, 'updateprofil'])->middleware('IsLogin');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('IsLogin');
Route::post('/dashboard', [DashboardController::class, 'report'])->middleware('IsLogin');


Route::get('/pengguna', [PenggunaController::class, 'index'])->middleware('IsLogin');
Route::post('/pengguna', [PenggunaController::class, 'store'])->middleware('IsLogin');
Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->middleware('IsLogin');
Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->middleware('IsLogin');

Route::get('/isian', [IsianController::class, 'index'])->middleware('IsLogin');
Route::get('/isian/detail/{id}', [IsianController::class, 'detailisian'])->middleware('IsLogin');
Route::post('/isian', [IsianController::class, 'store'])->middleware('IsLogin');
Route::put('/isian/{id}', [IsianController::class, 'update'])->middleware('IsLogin');
Route::delete('/isian/{id}', [IsianController::class, 'destroy'])->middleware('IsLogin');
