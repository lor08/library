<?php

namespace App\Services;

use App\Http\Resources\TopAuthorResource;
use App\Models\Author;

class AuthorService
{
    public function getTop(int $limit = 100)
    {
        $top = Author::withCount('books')->orderBy('books_count', 'desc')->limit($limit)->get();
        return TopAuthorResource::collection($top);
    }
}
