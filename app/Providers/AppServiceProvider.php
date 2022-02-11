<?php

namespace App\Providers;

use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\DiskController;
use App\Interfaces\LibraryItemInterface;
use App\Models\Book;
use App\Models\Disk;
use App\Services\LibraryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this
            ->app
            ->when(DiskController::class)
            ->needs(LibraryItemInterface::class)
            ->give(function () {
                return new LibraryService(Disk::class);
            });
        $this
            ->app
            ->when(BookController::class)
            ->needs(LibraryItemInterface::class)
            ->give(function () {
                return new LibraryService(Book::class);
            });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
