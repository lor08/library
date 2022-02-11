<?php

namespace App\Services;

use App\Filters\YearFilter;
use App\Http\Requests\AverageRequest;
use App\Interfaces\LibraryItemInterface;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LibraryService implements LibraryItemInterface
{
    public Model $model;

    const PER_PAGE = 25;

    /**
     * @param $class
     */
    public function __construct($class)
    {
        $this->model = new $class;
    }

    public function store(array $fields): JsonResponse
    {
        $item = $this->model->fill($fields);
        if ($item->save()) {
            if ($author = Author::firstOrCreate(['name' => $fields['author_name']]))
                $item->authors()->attach($author);
            Log::channel('scanner')->info('save scanner', compact('item', 'author'));
            return response()->json(['success' => true], 201);
        }
        return response()->json(['error' => true], 409);
    }

    public function searchByAuthorName(string $author)
    {
        return $this->model->whereHas('authors', function (Builder $query) use ($author) {
            $query->where('name', 'like', "%$author%");
        })->paginate(self::PER_PAGE);
    }

    public function getFilterList(Request $request)
    {
        $filter = new YearFilter($request);
        return $this->model->filter($filter)->paginate(self::PER_PAGE);
    }

    public function getCountByAuthor(string $author)
    {
        return $this->model->select('year', DB::raw('count(*) as count'))
            ->whereHas('authors', function (Builder $query) use ($author) {
                $query->where('name', $author);
            })
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
    }

    public function getTopAuthors(int $limit)
    {
        dd( class_basename($this->model) );
//        $top = Author::withCount('books')->orderBy('books_count', 'desc')->limit($limit)->get();
    }
}
