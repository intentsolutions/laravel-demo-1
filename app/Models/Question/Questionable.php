<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Questionable extends Model
{
    use HasFactory;

    public function questionable(): MorphTo
    {
        return $this->morphTo();
    }
}
