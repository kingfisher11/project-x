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
Route::view('/test', 'admin.layouts.main');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('admin');

Route::get('/trainings', [\App\Http\Controllers\TrainingController::class, 'index'])->name('training:list');
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
Route::get('/trainings/create', [\App\Http\Controllers\TrainingController::class, 'create'])->name('training:create'); // route utk display form
Route::post('/trainings/create', [\App\Http\Controllers\TrainingController::class, 'store'])->name('training:store');//route utk simpan data
Route::get('/trainings/{training}',[App\Http\Controllers\TrainingController::class, 'show'])->name('training:show');
Route::get('/trainings/{id}/edit',[App\Http\Controllers\TrainingController::class, 'edit'])->name('training:edit');
Route::post('/trainings/{id}/edit',[App\Http\Controllers\TrainingController::class, 'update'])->name('training:update');
Route::get('/trainings/{training}/delete',[App\Http\Controllers\TrainingController::class, 'delete'])->name('training:delete');
Route::get('/trainings/{training}/forceDelete',[App\Http\Controllers\TrainingController::class, 'forceDelete'])->name('training:forceDelete');
Route::get('/admin/audits', [App\Http\Controllers\AuditController::class, 'audit'])->middleware(['auth','admin'])->name('training:audit');

Route::get('/language/{locale}', [App\Http\Controllers\LocalizationController::class,'changelocale']);