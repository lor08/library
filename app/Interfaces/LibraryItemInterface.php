<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @return Collection
     */
    public function searchByAuthorName(string $author): Collection;

    /**
     * @param Request $request
     * @return Collection
     */
    public function getFilterList(Request $request): Collection;

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
