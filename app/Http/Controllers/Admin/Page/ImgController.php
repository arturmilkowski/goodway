<?php

namespace App\Http\Controllers\Admin\Page;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page\Page;
use Illuminate\Support\Facades\Storage;

class ImgController // extends Controller
{
    public function __invoke(Request $request, Page $page)
    {
        $imgId = $request->input('img_id');
        // dd($imgId);
        if ($imgId == 1) {
            Storage::disk('public')->delete($page->img);
            $page->img = null;
        }
        if ($imgId == 2) {
            Storage::disk('public')->delete($page->img1);
            $page->img1 = null;
        }

        $page->save();
    }
}
