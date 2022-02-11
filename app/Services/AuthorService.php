<?php

namespace App\Services;

use App\Http\Requests\CountByAuthorRequest;
use App\Http\Resources\TopBookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class AuthorService
{
    public function getTop(int $limit = 100): AnonymousResourceCollection
    {
        $top = Author::withCount('books')->orderBy('books_count', 'desc')->limit($limit)->get();
        return TopBookResource::collection($top);
    }

    public function getAverageCountBooks(CountByAuthorRequest $averageRequest)
    {
        $author_name = $averageRequest->get('author_name');
//        $author = Author::where('name', 'like', $author_name)->first();
        $books = Book::select('year', DB::raw('count(*) as count'))
            ->whereHas('authors', function (Builder $query) use ($author_name) {
                $query->where('name', $author_name);
            })
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->toArray();

        dd($books);
    }
}
