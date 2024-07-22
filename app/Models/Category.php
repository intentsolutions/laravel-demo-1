<?php

namespace App\Models;

use App\Traits\MediaAbilityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, MediaAbilityTrait, HasTranslation;

    protected $fillable = [
        'parent_id',
        'url',
        'sort',
        'status'
    ];

    protected $casts = [
        'sort' => 'integer',
        'status' => 'boolean'
    ];

    protected array $translationFillable = [
        'language',
        'category_id',
        'name',
        'meta_title',
        'meta_description',
        'short_description',
        'description',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('image')->nonQueued();
        $this->addMediaConversion('banner')->nonQueued();
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }
}
