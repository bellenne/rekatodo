<?php

use App\Http\Controllers\Lists;
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
Route::get('/', Lists\IndexController::class)->middleware("auth")->name("index");


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/shareGetLink', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/share', [App\Http\Controllers\ShareController::class, 'index'])->name("shareLink");
Route::get('/search', [App\Http\Controllers\SearchController::class, "search"])->name("search");
Route::get('/filter', [App\Http\Controllers\SearchController::class, "filter"])->name("filter");


