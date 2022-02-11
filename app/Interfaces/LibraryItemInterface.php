<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 *
 */
interface LibraryItemInterface
{
    /**
     * @param array $fields
     * @return JsonResponse
     */
    public function store(array $fields): JsonResponse;

    /**
     * @param string $author
     * @return LengthAwarePaginator
     */
    public function searchByAuthorName(string $author): LengthAwarePaginator;

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getFilterList(Request $request): LengthAwarePaginator;

    /**
     * @param string $author
     * @return Collection
     */
    public function getCountByAuthor(string $author): Collection;

    /**
     * @param string $relation
     * @param int $limit
     * @return Collection
     */
    public function getTopAuthors(string $relation, int $limit = 100): Collection;
}
