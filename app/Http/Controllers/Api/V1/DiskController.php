<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AverageRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreDiskRequest;
use App\Http\Resources\DiskCollection;
use App\Interfaces\LibraryItemInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiskController extends Controller
{
    private LibraryItemInterface $library;

    public function __construct(LibraryItemInterface $library)
    {
        $this->library = $library;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return DiskCollection
     */
    public function index(Request $request): DiskCollection
    {
        return new DiskCollection($this->library->getFilterList($request));
    }

    /**
     * Search ba author name.
     *
     * @param SearchRequest $searchRequest
     * @return DiskCollection
     */
    public function search(SearchRequest $searchRequest): DiskCollection
    {
        return new DiskCollection(
            $this
                ->library
                ->searchByAuthorName($searchRequest->get('author_name'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiskRequest $request
     * @return JsonResponse
     */
    public function store(StoreDiskRequest $request): JsonResponse
    {
        return $this->library->store($request->all());
    }

    public function countByAuthor(AverageRequest $request)
    {
        return $this->library->getCountByAuthor($request->get('author_name'));
    }
}
