<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class RelationHelper
{
    public static function saveRelationRecursive(Model $entity, array $data): void
    {
        foreach ($data as $relation => $datum) {
            if ($relation == 'translations') {
                $datum = array_values($datum);
            }

            if (!in_array($datum, $entity->getFillable()) && method_exists($entity, $relation)) {

                $entity->{$relation}()->delete();

                if (array_values($datum) === $datum) {
                    foreach ($datum as $item) {
                        $subEntity = $entity->{$relation}()->create($item);

                        RelationHelper::saveRelationRecursive($subEntity, $item);
                    }
                } else {
                    $entity->{$relation}()->create($datum);
                }
            }
        }
    }
}
