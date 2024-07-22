<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Category\CategoryRequest;
use App\Http\Resources\Admin\Category\CategoryCollection;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Services\Api\V1\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $courseCategoryService)
    {
    }

    /**
     * @OA\Get(
     *      path="/admin/categories",
     *      operationId="adminShowCategories",
     *      tags={"Admin Categories"},
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
        return new CategoryCollection($this->courseCategoryService->getAll($request->all()));
    }

    /**
     * @OA\Get(
     *      path="/admin/categories/{id}",
     *      operationId="adminShowCourseCategory",
     *      tags={"Admin Categories"},
     *      summary="Show courseCategory",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="id", in="path", required=true),
     *      @OA\Response(response=200, description="Successful operation", @OA\JsonContent()),
     * )
     */
    public function show(int $id): CategoryResource
    {
        return new CategoryResource($this->courseCategoryService->show($id));
    }

    /**
     * @OA\Post(
     *      path="/admin/categories",
     *      operationId="adminStoreCourseCategory",
     *      tags={"Admin Categories"},
     *      summary="Store new courseCategory",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *      ),
     *      @OA\Response(response=201, description="Successful operation", @OA\JsonContent()),
     * )
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        return new CategoryResource($this->courseCategoryService->store($request->validated()));
    }

    /**
     * @OA\Put(
     *      path="/admin/categories/{id}",
     *      operationId="adminUpdateCourseCategory",
     *      tags={"Admin Categories"},
     *      summary="Update courseCategory",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="id", in="path", required=true),
     *      @OA\Parameter(name="limit", in="query", required=false),
     *      @OA\RequestBody(required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *      ),
     *      @OA\Response(response=200, description="Successful operation", @OA\JsonContent()),
     * )
     */
    public function update(CategoryRequest $request, int $id): CategoryResource
    {
        return new CategoryResource($this->courseCategoryService->update($request->validated(), $id));
    }

    /**
     * @OA\Delete(
     *      path="/admin/categories/{id}",
     *      operationId="adminDeleteCourseCategory",
     *      tags={"Admin Categories"},
     *      summary="Delete existing courseCategory",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="id", in="path", required=true),
     *      @OA\Response(response=204, description="Successful operation", @OA\JsonContent()),
     * )
     */
    public function destroy(int $id): Response
    {
        $this->courseCategoryService->destroy($id);

        return response()->noContent();
    }
}
