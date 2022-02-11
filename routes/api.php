<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\DiskController;
use App\Http\Controllers\Api\V1\MainController;
use App\Http\Controllers\Api\V1\AuthorController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::name('api.v1.')->prefix('v1')->group(function () {
    Route::apiResource('books', BookController::class)->only(['index', 'store']);
    Route::post('books/search', [BookController::class, 'search'])->name('books.search');
    Route::post('books/count_by_author', [BookController::class, 'countByAuthor'])->name('books.count_by_author');

    Route::apiResource('disks', DiskController::class)->only(['index', 'store']);
    Route::post('disks/search', [DiskController::class, 'search'])->name('disks.search');
    Route::post('disks/count_by_author', [DiskController::class, 'countByAuthor'])->name('disks.count_by_author');

    Route::get('top_authors', [AuthorController::class, 'top'])->name('authors.top');

//    Route::apiResource('authors', AuthorController::class);
//    Route::post('authors/average', [AuthorController::class, 'average'])->name('authors.average');
//    Route::post('search', [MainController::class, 'search'])->name('main.search');
//    Route::post('scan', [MainController::class, 'scan'])->name('main.scan');
});
