<?php

namespace App\Services;

use App\Filters\YearFilter;
use App\Http\Requests\CountByAuthorRequest;
use App\Interfaces\LibraryItemInterface;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 *
 */
class LibraryService implements LibraryItemInterface
{
    /**
     * @var Model|mixed
     */
    public Model $model;

    /**
     *
     */
    const PER_PAGE = 25;

    /**
     * @param $class
     */
    public function __construct($class)
    {
        $this->model = new $class;
    }

    /**
     * @param array $fields
     * @return JsonResponse
     */
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

    /**
     * @param string $author
     * @return Collection
     */
    public function searchByAuthorName(string $author): Collection
    {
        return $this->model->whereHas('authors', function (Builder $query) use ($author) {
            $query->where('name', 'like', "%$author%");
        })->paginate(self::PER_PAGE);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function getFilterList(Request $request): Collection
    {
        $filter = new YearFilter($request);
        return $this->model->filter($filter)->paginate(self::PER_PAGE);
    }

    /**
     * @param string $author
     * @return Collection
     */
    public function getCountByAuthor(string $author): Collection
    {
        return $this->model->select('year', DB::raw('count(*) as count'))
            ->whereHas('authors', function (Builder $query) use ($author) {
                $query->where('name', $author);
            })
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
    }

    /**
     * @param string $relation
     * @param int $limit
     * @return Collection
     */
    public function getTopAuthors(string $relation, int $limit = 100): Collection
    {
        return Author::withCount($relation)->orderBy("{$relation}_count", 'desc')->limit($limit)->get();
    }
}
