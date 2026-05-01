<?php

namespace App\Models\Blog\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Blog\Post\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'img',
        'img1',
        'approved',
        'published',
        'comments_allowed',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'published' => 'boolean',
        'comments_allowed' => 'boolean',
    ];

    #[Scope]
    protected function approved(Builder $query): void
    {
        $query->where('approved', 1);
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('published', 1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PostTranslation::class);
    }


    // Helpery tłumaczeń

    public function translation(): HasOne
    {
        return $this->hasOne(PostTranslation::class)->where('locale', app()->getLocale());
    }

    public function translate(string $locale): ?PostTranslation
    {
        $translation = $this->translations->firstWhere('locale', $locale);

        if (!$translation) {
            $fallback = config('app.fallback_locale', 'pl');
            $translation = $this->translations->firstWhere('locale', $fallback);
        }

        return $translation;
    }

    public function getCurrentTranslationAttribute(): ?PostTranslation
    {
        return $this->translate(app()->getLocale());
    }
}
