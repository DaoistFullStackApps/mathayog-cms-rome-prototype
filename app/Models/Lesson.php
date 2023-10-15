<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    public function courseSkillTitle(): BelongsTo {
        return $this->belongsTo(CourseSkillTitle::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
