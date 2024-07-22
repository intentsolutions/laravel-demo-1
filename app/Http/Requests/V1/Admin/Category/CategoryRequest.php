<?php

namespace App\Http\Requests\V1\Admin\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @OA\Schema(
 *      title="Category request",
 *      description="Category request body data",
 *      type="object",
 *      required={ "url", "sort", "status", "translations"}
 * ),
 * @OA\Property(property="parent_id", type="integer", example="null"),
 * @OA\Property(property="url", type="string"),
 * @OA\Property(property="sort", type="integer"),
 * @OA\Property(property="status", type="tinyint", title="status", example="1"),
 * @OA\Property(property="image", type="object", @OA\Property(property="id", type="integer", example="null"),),
 * @OA\Property(property="banner", type="object", @OA\Property(property="id",type="integer", example="null"),),
 * @OA\Property(
 *     property="translations",
 *     type="array",
 *     @OA\Items(
 *         required={"title", "language", "name"},
 *         @OA\Property(property="title", type="string"),
 *         @OA\Property(property="language", type="string"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="short_description", type="string"),
 *         @OA\Property(property="meta_title", type="string"),
 *         @OA\Property(property="meta_description", type="string"),
 *     )
 * )
 */
class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['sometimes', 'nullable', 'exists:' . Category::class . ',id'],
            'url' => ['required', Rule::unique('categories')->ignore($this->id)],
            'sort' => ['required'],
            'status' => ['required'],
            'image.id' => ['sometimes', 'nullable', 'exists:' . Media::class . ',id'],
            'banner.id' => ['sometimes', 'nullable', 'exists:' . Media::class . ',id'],
            'translations.*.language' => ['required'],
            'translations.*.name' => ['required'],
            'translations.*.description' => ['sometimes'],
            'translations.*.short_description' => ['sometimes'],
            'translations.*.meta_title' => ['sometimes'],
            'translations.*.meta_description' => ['sometimes'],
        ];
    }
}
