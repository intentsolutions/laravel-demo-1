<?php

namespace App\Services\Api\V1\Admin;

use App\Repositories\BlogCategoryRepository;

class BlogCategoryService
{
    public function __construct(private readonly BlogCategoryRepository $blogCategoryRepository)
    {
    }

    public function getAll(array $params = []): mixed
    {
        return $this->blogCategoryRepository->getAll($params);
    }

    public function show(int $id): mixed
    {
         return $this->blogCategoryRepository->getById($id);
    }

    public function store(array $data): mixed
    {
        $blogCategory = $this->blogCategoryRepository->create($data);

        $blogCategory->syncMedia($data['image'] ?? null, 'image');
        $blogCategory->syncMedia($data['banner'] ?? null, 'banner');

        return $blogCategory;
    }

    public function update(array $data, int $id): mixed
    {
        $blogCategory = $this->blogCategoryRepository->update($data, $id);

        $blogCategory->syncMedia($data['image'] ?? null, 'image');
        $blogCategory->syncMedia($data['banner'] ?? null, 'banner');

        return $blogCategory;
    }

    public function destroy(int $id): mixed
    {
        return $this->blogCategoryRepository->delete($id);
    }
}
