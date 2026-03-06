<?php

namespace App\Models\Admin\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Admin\Blog\PostFactory> */
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

    /**
     * Scope a query to only include to show approved posts.
     */
    /*
     public function scopeApproved(Builder $query): void
    {
        $query->where('approved', true);
    }
    */

    /**
     * Scope a query to only include to show approved posts.
     */
    /*
    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }
    */
}
