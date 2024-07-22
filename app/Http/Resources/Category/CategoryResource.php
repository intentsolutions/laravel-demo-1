<?php

namespace App\Http\Resources\Category;

use App\Helpers\TranslationHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'sort' => $this->sort,
            'status' => (bool)$this->status,
            'image' => $this->getMedia('image')->first(),
            'banner' => $this->getMedia('banner')->first(),
            ...TranslationHelper::getTranslation($this->resource,$request->header('Accept-Language') ?? config('app.locale'))
        ];
    }
}
