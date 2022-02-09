<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\DiskController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('books', BookController::class);
Route::apiResource('disks', DiskController::class);

Route::apiResource('authors', AuthorController::class);
Route::get('top_authors', [AuthorController::class, 'top'])->name('authors.top');

Route::post('search', [MainController::class, 'search'])->name('main.search');
Route::post('scan', [MainController::class, 'scan'])->name('main.scan');
