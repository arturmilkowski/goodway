<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};
use App\Models\User;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\Project\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'img',
        'img1',
        'approved',
        'hide',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'hide'     => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(ProjectTranslation::class)
            ->where('locale', app()->getLocale());
    }

    public function translate(string $locale): ?ProjectTranslation
    {
        $translation = $this->translations->firstWhere('locale', $locale);

        if (!$translation) {
            $fallback = config('app.fallback_locale', 'pl');
            $translation = $this->translations->firstWhere('locale', $fallback);
        }

        return $translation;
    }

    public function getCurrentTranslationAttribute(): ?ProjectTranslation
    {
        return $this->translate(app()->getLocale());
    }
}
