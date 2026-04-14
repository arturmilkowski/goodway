<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class PageTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\Page\PageTranslationFactory> */
    use HasFactory;
    protected $fillable = [
        'page_id',
        'user_id',
        'slug',
        'locale',
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

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
