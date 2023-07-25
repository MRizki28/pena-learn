<?php

use App\Http\Controllers\API\MahasiswaController;
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
});


Route::get('/mahasiswa' , [MahasiswaController::class , 'getAllData']);
Route::post('/mahasiswa/create' , [MahasiswaController::class , 'createData']);
Route::get('/mahasiswa/get/{id}' , [MahasiswaController::class , 'getDataById']);
Route::post('/mahasiswa/update/{id}' , [MahasiswaController::class , 'updateData']);



