<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Project\Project;
use App\Http\Requests\Admin\Project\StoreProjectRequest;

class ProjectController // extends Controller
{
    private string $projectImgPath = 'images/project';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->get();

        return Inertia::render('admin/project/Index', [
            'projects' => $projects,
            'path' => asset('storage')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/project/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            $path = $request->file('imgFile')->storePublicly($this->projectImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            $path = $request->file('imgFile1')->storePublicly($this->projectImgPath, 'public');
            $validated['img1'] = $path;
        }

        Project::create($validated);

        Inertia::flash([
            'message' => 'Dodano',
        ]);

        return to_route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return Inertia::render('admin/project/Show', [
            'project' => $project,
            'path' => asset('storage')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('admin/project/Edit', [
            'project' => $project,
            'path' => asset('storage')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        $file = $request->file('imgFile');
        if ($file) {
            if ($project->img) {
                Storage::disk('public')->delete($project->img);
            }
            $path = $request->file('imgFile')->storePublicly($this->projectImgPath, 'public');
            $validated['img'] = $path;
        }

        $file1 = $request->file('imgFile1');
        if ($file1) {
            if ($project->img1) {
                Storage::disk('public')->delete($project->img1);
            }
            $path1 = $request->file('imgFile1')->storePublicly($this->projectImgPath, 'public');
            $validated['img1'] = $path1;
        }

        $project->update($validated);

        Inertia::flash([
            'message' => 'Zmieniono',
        ]);

        return to_route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project  $project)
    {
        if ($project->img) {
            Storage::disk('public')->delete($project->img);
        }
        if ($project->img1) {
            Storage::disk('public')->delete($project->img1);
        }

        $project->delete();

        Inertia::flash([
            'message' => 'Usunięto',
        ]);

        return to_route('admin.projects.index');
    }
}
