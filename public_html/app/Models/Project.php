<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'tagline',
        'location',
        'specifications',
        'location_url',
        'status',
        'is_featured',
        'description',

        'ideal_title',
        'ideal_description',
        'ideal_image',

        'tranquil_title',
        'tranquil_description',
        'tranquil_image',

        'cover_image',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            $project->slug = static::generateUniqueSlug($project->title);
        });

        static::updating(function (Project $project) {
            if ($project->isDirty('title')) {
                $project->slug = static::generateUniqueSlug(
                    $project->title,
                    $project->id
                );
            }
        });
    }

    protected static function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $slug = Str::slug($title);

        $originalSlug = $slug;
        $counter = 1;

        while (
        static::query()
            ->where('slug', $slug)
            ->when(
                $ignoreId,
                fn ($query) => $query->where('id', '!=', $ignoreId)
            )
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile();

        $this->addMediaCollection('ideal')
            ->singleFile();

        $this->addMediaCollection('tranquil')
            ->singleFile();

        $this->addMediaCollection('gallery');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenities::class, 'amenities_project', 'project_id', 'amenities')
            ->withTimestamps();
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'Ongoing');
    }
}
