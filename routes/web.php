<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/trainings', [\App\Http\Controllers\TrainingController::class, 'index'])->name('training:list');
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
Route::get('/trainings/create', [\App\Http\Controllers\TrainingController::class, 'create'])->name('training:create'); // route utk display form
Route::post('/trainings/create', [\App\Http\Controllers\TrainingController::class, 'store']); //route utk simpan data
Route::get('/trainings/{id}',[App\Http\Controllers\TrainingController::class, 'show'])->name('training:show');