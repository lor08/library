<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\DiskController;

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
    Route::get('books/top_authors', [BookController::class, 'topAuthor'])->name('books.top_authors');

    Route::apiResource('disks', DiskController::class)->only(['index', 'store']);
    Route::post('disks/search', [DiskController::class, 'search'])->name('disks.search');
    Route::post('disks/count_by_author', [DiskController::class, 'countByAuthor'])->name('disks.count_by_author');
    Route::get('disks/top_authors', [DiskController::class, 'topAuthor'])->name('disks.top_authors');
});
