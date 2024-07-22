<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait ContentRelations
{
    public function content(): HasMany
    {
        return $this->hasMany(Contentable::class)->with('contentable');
    }

    public function video(): MorphToMany
    {
        return $this->morphedByMany(ContentVideo::class, 'contentable');
    }

    public function text(): MorphToMany
    {
        return $this->morphedByMany(ContentText::class, 'contentable');
    }
}
