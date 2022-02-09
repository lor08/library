<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScanRequest;
use App\Http\Requests\SearchRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scan(ScanRequest $scanRequest)
    {
//        print_r($scanRequest->json()->all());
//        $validated = $scanRequest->validated();
        return response()->json($scanRequest->all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(SearchRequest $searchRequest): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $this->bookService->searchByAuthorName($searchRequest->get('author_full_name'));
    }
}
