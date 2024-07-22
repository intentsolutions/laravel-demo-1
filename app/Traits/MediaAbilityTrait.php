<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait MediaAbilityTrait
{
    public function syncMedia(?array $image, string $collectionName): void
    {
        $currentMediaId = Media::where([
            'model_type' => $this::class,
            'model_id' => $this->id,
            'collection_name' => $collectionName,
        ])->first()?->id;

        if (!isset($image['id']) || $currentMediaId !== $image['id']) {
            $this->clearMediaCollection($collectionName);
        }

        if ($image && $image['id'] && $currentMediaId !== $image['id']) {
            $media = Media::find($image['id']);

            if ($media) {
                $media->copy($this, $collectionName);
            }
        }
    }
}
