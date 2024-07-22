<?php

namespace App\Models\Question;

use App\Models\Content\Contentable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait QuestionRelations
{
    public function questions(): HasMany
    {
        return $this->hasMany(Questionable::class)
            ->with(['questionable' => function ($q) {
                if (method_exists($q->first()->questionable->getModel(), 'translations')) {
                    $q->with('translations');
                }
            }]);
    }

    public function correctChoice(): MorphToMany
    {
        return $this->morphedByMany(QuestionCorrectChoice::class, 'questionable');
    }

    public function entryText(): MorphToMany
    {
        return $this->morphedByMany(QuestionEntryText::class, 'questionable');
    }
}
