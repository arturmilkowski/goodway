<?php

namespace App\Models\Blog\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Blog\Post\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'intro',
        'content',
        'img',
        'img1',
        'site_description',
        'site_keyword',
        'approved',
        'published',
        'comments_allowed',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'published' => 'boolean',
        'comments_allowed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
}
