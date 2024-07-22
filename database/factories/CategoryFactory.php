<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'parent_id' => null,
            'url' => 'category-course-url',
            'sort' => 0,
            'status' => true,
        ];
    }
}
