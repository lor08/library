<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountByAuthorRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreDiskRequest;
use App\Http\Resources\DiskCollection;
use App\Http\Resources\TopBookResource;
use App\Http\Resources\TopDiskResource;
use App\Interfaces\LibraryItemInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 *
 */
class DiskController extends Controller
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
        return TopDiskResource::collection(
            $this->library->getTopAuthors('disks')
        );
    }
}
