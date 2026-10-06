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
    public const LORESHO_MAPS_URL = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4919.970799173085!2d36.74429797567676!3d-1.2552488111263767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f19007b338919%3A0xb98835a6bb981f00!2sSandalwood%20Loresho!5e0!3m2!1sen!2ske!4v1773423345983!5m2!1sen!2ske';
    public const KITISURU_MAPS_URL = 'https://www.google.com/maps/search/?api=1&query=Sandalwood%20Kitisuru%2C%20Nairobi%2C%20Kenya&query_place_id=ChIJr4BV7FoZLxgRYY_F2SP0610';

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
