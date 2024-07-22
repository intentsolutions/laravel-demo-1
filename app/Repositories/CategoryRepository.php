<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = Category::class;

        $this->filters = ['status'];
        $this->sorts = ['sort'];
    }

    public function getByUrl(string $url): mixed
    {
        return $this->model::whereUrl($url)->firstOrFail();
    }

    public function create(array $data): mixed
    {
        $category = $this->model::create($data);

        if (isset($data['translations'])) {
            $this->updateTranslations($category, $data['translations']);
        }

        return $category;
    }

    public function update(array $data, int $id): mixed
    {
        $category = $this->model::where('id', $id)->first();
        $category->update($data);

        if (isset($data['translations'])) {
            $this->updateTranslations($category, $data['translations']);
        }

        return $category;
    }

    private function updateTranslations(Category $category, array $translations): void
    {
        $category->translations()->delete();

        foreach ($translations as $translation) {
            $category->translations()->create($translation);
        }
    }
}
