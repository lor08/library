<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface LibraryItemInterface
{
    public function store(array $fields): JsonResponse;
    public function searchByAuthorName(string $author);
    public function getFilterList(Request $request);
}
