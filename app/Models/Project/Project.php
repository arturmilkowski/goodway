<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use App\Models\User;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\Project\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'intro',
        'content',
        'result',
        'img',
        'img1',
        'site_description',
        'site_keyword',
        'approved',
        'hide',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'hide' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
