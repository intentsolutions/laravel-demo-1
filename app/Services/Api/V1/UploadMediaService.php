<?php

namespace App\Services\Api\V1;

use App\Http\Requests\V1\UploadMedia\StoreMediaRequest;
use App\Models\TempMediaFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class UploadMediaService
{
    public function uploadTempFile(StoreMediaRequest $request): ?Media
    {
        if ($request->hasFile('file')) {
            return TempMediaFile::create(['name' => $request->file->getClientOriginalName()])
                ->addMediaFromRequest('file')
                ->toMediaCollection('temp_media');
        }

        return null;
    }

    public function destroy(int $id): void
    {
        $media = Media::find($id);

        if ($media->model_type === TempMediaFile::class) {
            $media->model->delete();
        }

        $media->delete();
    }
}
