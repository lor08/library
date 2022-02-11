<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\YearFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountByAuthorRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\TopBookResource;
use App\Interfaces\LibraryItemInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 *
 */
class BookController extends Controller
{
    /**
     * @var LibraryItemInterface
     */
    private LibraryItemInterface $library;

    /**
     * @param LibraryItemInterface $library
     */
    public function __construct(LibraryItemInterface $library)
    {
        $this->library = $library;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return BookCollection
     */
    public function index(Request $request): BookCollection
    {
        return new BookCollection(
            $this
                ->library
                ->getFilterList($request)
        );
    }

    /**
     * Search ba author name.
     *
     * @param SearchRequest $searchRequest
     * @return BookCollection
     */
    public function search(SearchRequest $searchRequest): BookCollection
    {
        return new BookCollection(
            $this
                ->library
                ->searchByAuthorName($searchRequest->get('author_name'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBookRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        return $this->library->store($request->all());
    }

    /**
     * @param CountByAuthorRequest $request
     * @return Collection
     */
    public function countByAuthor(CountByAuthorRequest $request): Collection
    {
        return $this->library->getCountByAuthor($request->get('author_name'));
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function topAuthor(): AnonymousResourceCollection
    {
        return TopBookResource::collection(
            $this->library->getTopAuthors('books')
        );
    }
}
