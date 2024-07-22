<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Api\V1\CategoryService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    /**
     * @OA\Get(
     *      path="/categories",
     *      operationId="clientShowCategories",
     *      tags={"Categories"},
     *      summary="Show Categories",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="sort", in="query", required=false),
     *      @OA\Parameter(name="sort_direction", in="query", required=false),
     *      @OA\Parameter(name="limit", in="query", required=false),
     *      @OA\Response(response=200, description="Successful operation", @OA\JsonContent()),
     * )
     */
    public function index(Request $request): CategoryCollection
    {
        return new CategoryCollection($this->categoryService->getAll($request->all()));
    }

    /**
     * @OA\Get(
     *      path="/categories/{url}",
     *      operationId="clientShowCourseCategory",
     *      tags={"Categories"},
     *      summary="Show courseCategory",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="id", in="path", required=true),
     *      @OA\Response(response=200, description="Successful operation", @OA\JsonContent()),
     * )
     */
    public function show(string $url): CategoryResource
    {
        return new CategoryResource($this->categoryService->show($url));
    }
}
