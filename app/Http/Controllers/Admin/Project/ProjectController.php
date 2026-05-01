<?php

namespace App\Http\Controllers\Admin\Project;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Project\Project;
use App\Http\Requests\Admin\Project\StoreProjectRequest;

class ProjectController
{
    private string $projectImgPath = 'images/project';

    public function index(): Response
    {
        $projects = Project::with([
            'translations' => fn($q) =>
            $q->where('locale', 'pl')
                ->select('project_id', 'locale', 'title', 'slug')
        ])->latest()->get();

        return Inertia::render('admin/project/Index', [
            'projects' => $projects,
            'path'     => asset('storage'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/project/Create', [
            'locales' => config('settings.locales', ['pl', 'en']),
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            $path = $file->storePublicly($this->projectImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            $path1 = $file1->storePublicly($this->projectImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $project = Project::create([
            ...collect($validated)->except('translations')->toArray(),
            'user_id' => Auth::id(),
        ]);

        foreach ($validated['translations'] as $locale => $translation) {
            if (empty($translation['title']) || trim($translation['title']) === '') {
                continue;
            }

            $project->translations()->create([
                'locale'           => $locale,
                'user_id'          => Auth::id(),
                'slug'             => $translation['slug'],
                'title'            => $translation['title'],
                'intro'            => $translation['intro'] ?? null,
                'content'          => $translation['content'] ?? null,
                'result'           => $translation['result'] ?? null,
                'site_description' => $translation['site_description'] ?? null,
                'site_keyword'     => $translation['site_keyword'] ?? null,
            ]);
        }

        Inertia::flash(['message' => 'Dodano']);

        return to_route('admin.projects.index');
    }

    public function show(Project $project): Response
    {
        $project->load(['translations']);

        return Inertia::render('admin/project/Show', [
            'project' => $project,
            'locales' => config('settings.locales', ['pl', 'en']),
            'path'    => asset('storage'),
        ]);
    }

    public function edit(Project $project): Response
    {
        $project->load(['translations']);

        return Inertia::render('admin/project/Edit', [
            'project' => $project,
            'locales' => config('settings.locales', ['pl', 'en']),
            'path'    => asset('storage'),
        ]);
    }

    public function update(StoreProjectRequest $request, Project $project): RedirectResponse
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            if ($project->img) {
                Storage::disk('public')->delete($project->img);
            }
            $path = $file->storePublicly($this->projectImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            if ($project->img1) {
                Storage::disk('public')->delete($project->img1);
            }
            $path1 = $file1->storePublicly($this->projectImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $project->update(collect($validated)->except('translations')->toArray());

        foreach ($validated['translations'] as $locale => $translation) {
            if (empty($translation['title']) || trim($translation['title']) === '') {
                continue;
            }

            $project->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'user_id'          => Auth::id(),
                    'slug'             => $translation['slug'],
                    'title'            => $translation['title'],
                    'intro'            => $translation['intro'] ?? null,
                    'content'          => $translation['content'] ?? null,
                    'result'           => $translation['result'] ?? null,
                    'site_description' => $translation['site_description'] ?? null,
                    'site_keyword'     => $translation['site_keyword'] ?? null,
                ]
            );
        }

        Inertia::flash(['message' => 'Zmieniono']);

        return to_route('admin.projects.show', $project);
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->img) {
            Storage::disk('public')->delete($project->img);
        }
        if ($project->img1) {
            Storage::disk('public')->delete($project->img1);
        }

        $project->delete();

        Inertia::flash(['message' => 'Usunięto']);

        return to_route('admin.projects.index');
    }
}
