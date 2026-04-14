<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\Page\PageFactory> */
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'user_id',
        // 'slug',
        // 'title',
        // 'intro',
        //  'content',
        'img',
        'img1',
        // 'site_description',
        //  'site_keyword',
        'navbar',
        'hide',
        'ordinal',
    ];

    /**
     * Get the route key for the model.
     */
    /*
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    */

    protected $casts = [
        'navbar' => 'boolean',
        'hide' => 'boolean',
    ];

    #[Scope]
    protected function navbar(Builder $query): void
    {
        $query->where('navbar', 1);
    }

    #[Scope]
    protected function notHide(Builder $query): void
    {
        $query->where('hide', 0);
    }

    #[Scope]
    protected function parentPage(Builder $query): void
    {
        $query->where('parent_id', null);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('ordinal');
    }

    // Rekurencyjne pobieranie wszystkich podstron (dla menu)
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    // Sprawdza czy strona ma podstrony
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    // Sprawdza czy strona jest podstroną
    public function isSubpage(): bool
    {
        return !is_null($this->parent_id);
    }

    // Pobiera pełną ścieżkę (dla breadcrumbs)
    public function getPathAttribute(): array
    {
        $path = [];
        $current = $this;

        while ($current) {
            array_unshift($path, $current);
            $current = $current->parent;
        }

        return $path;
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class,);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(PageTranslation::class)->where('locale', app()->getLocale());
    }
}
