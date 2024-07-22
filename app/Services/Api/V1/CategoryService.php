<?php

namespace App\Services\Api\V1;

use App\Repositories\CategoryRepository;

final class CategoryService
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function getAll(array $params = []): mixed
    {
        $params['sort'] = 'sort';
        $params['status'] = true;

        return $this->categoryRepository->getAll($params);
    }

    public function show(string $url): mixed
    {
        return $this->categoryRepository->getByUrl($url);
    }
}
