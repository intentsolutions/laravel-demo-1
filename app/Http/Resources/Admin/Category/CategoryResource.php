<?php

namespace App\Http\Resources\Admin\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'url' => $this->url,
            'sort' => $this->sort,
            'status' => (bool)$this->status,
            'image' => $this->getMedia('image')->first(),
            'banner' => $this->getMedia('banner')->first(),
            'translations' => $this->translations,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
