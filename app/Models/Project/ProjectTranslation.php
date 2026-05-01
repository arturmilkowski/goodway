<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ProjectTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\Project\ProjectTranslationFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'locale',       // ← było brak
        'slug',
        'title',
        'intro',
        'content',
        'result',
        'site_description',
        'site_keyword',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
