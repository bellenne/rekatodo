<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::delete("/list/remove", \App\Http\Controllers\Lists\RemoveController::class)->name("list.remove");
Route::get("/list/create", \App\Http\Controllers\Lists\CreateController::class)->name("list.create");
Route::get("/list/edit", [\App\Http\Controllers\Lists\UpdateController::class, "update"])->name("list.edit");

Route::get("/task/edit", [\App\Http\Controllers\TaskController::class, "update"])->name("task.edit");
Route::post("/task/create", [\App\Http\Controllers\TaskController::class, "create"])->name("task.create");
Route::delete("/task/remove", [\App\Http\Controllers\TaskController::class, "remove"])->name("task.remove");
Route::post("/task/edit/all", [\App\Http\Controllers\TaskController::class, "updateAll"])->name("task.edit.all");


Route::get("/tag/create", [\App\Http\Controllers\TagController::class, "create"])->name("tag.create");
Route::delete("/tag/remove", [\App\Http\Controllers\TagController::class, "remove"])->name("tag.remove");

Route::get('/share/getLink', [\App\Http\Controllers\ShareController::Class,"AjaxGetLink"])->name("shareGetLink");
