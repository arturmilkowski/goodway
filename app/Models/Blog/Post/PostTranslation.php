<?php

namespace App\Models\Blog\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class PostTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\Blog\Post\PostTranslationFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'intro',
        'content',
        'site_description',
        'site_keyword',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
