<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;

class ProjectController extends Controller
{
    public function show(string $locale, string $slug)
    {
        $project = Project::whereHas(
            'translations',
            fn($q) =>
            $q->where('locale', app()->getLocale())
                ->where('slug', $slug)
        )->with(['translation'])->firstOrFail();

        return view('project.show', [
            'project' => $project,
            'path'    => asset('storage'),
        ]);
    }
}
