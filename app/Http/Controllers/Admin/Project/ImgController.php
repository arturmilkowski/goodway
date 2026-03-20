<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project\Project;
use Illuminate\Support\Facades\Storage;

class ImgController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Project $project)
    {
        $imgId = $request->input('img_id');

        if ($imgId == 1) {
            Storage::disk('public')->delete($project->img);
            $project->img = null;
        }
        if ($imgId == 2) {
            Storage::disk('public')->delete($project->img1);
            $project->img1 = null;
        }

        $project->save();
    }
}
