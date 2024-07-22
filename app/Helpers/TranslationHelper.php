<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TranslationHelper
{
    private const HIDDEN = [
        'id',
        'language',
        'created_at',
        'updated_at'
    ];

    public static function getTranslation(Model $entity, string $lang = ''): array
    {
        if (empty($lang)) {
            $lang = request()->header('Accept-Language') ?? config('app.locale');
        }

        $translation = $entity->translations()->where('language', $lang)->first();

        if ($translation) {
            $translation->makeHidden(self::HIDDEN);
            $translation->makeHidden(Str::singular($entity->getTable()) . '_id');

            return $translation->toArray();
        }

        return array_diff_key(array_fill_keys($entity->getTranslationFillable(), null), array_fill_keys([...self::HIDDEN, Str::singular($entity->getTable()) . '_id'] , null));
    }

    public static function getTranslationField(Model|null $entity, string $lang, string $field): ?string
    {
        if ($entity) {
            $translation = $entity->translations()->where('language', $lang)->first();

            return $translation->{$field} ?? null;
        }

        return null;
    }
}
