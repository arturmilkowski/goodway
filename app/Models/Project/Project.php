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
        'img',
        'img1',
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
