<?php

use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KuotaProdiController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\WisudaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resource('jurusan', JurusanController::class);
Route::resource('prodi', ProdiController::class);
Route::resource('wisuda', WisudaController::class);
Route::resource('kuota_prodi', KuotaProdiController::class);
