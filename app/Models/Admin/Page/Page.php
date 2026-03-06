<?php

namespace App\Models\Admin\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\User;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\Admin\PageFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'intro',
        'content',
        'img',
        'img1',
        'site_description',
        'site_keyword',
        'navbar',
        'hide',
        'ordinal',
    ];

    protected $casts = [
        'navbar' => 'boolean',
        'hide' => 'boolean',
    ];

    /*
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    */
}
