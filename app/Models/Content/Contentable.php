<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contentable extends Model
{
    use HasFactory;

    public function contentable(): MorphTo
    {
        return $this->morphTo();
    }
}
