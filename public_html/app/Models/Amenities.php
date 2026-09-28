<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenities extends Model
{
    protected $fillable = [
        'name',
        'image',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withTimestamps();
    }
}
