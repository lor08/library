<?php

namespace App\Services;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;

class BookService
{
    public function searchByAuthorName(string $author): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $books = Book::whereHas('authors', function (Builder $query) use ($author) {
            $query->where('name', 'like', "%$author%");
        })->get();

        return BookResource::collection($books);
    }
}
