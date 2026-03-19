<?php

namespace App\Http\Controllers\Admin\Blog\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\Post\Post;
use Illuminate\Support\Facades\Storage;

class ImgController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $imgId = $request->input('img_id');

        if ($imgId == 1) {
            Storage::disk('public')->delete($post->img);
            $post->img = null;
        }
        if ($imgId == 2) {
            Storage::disk('public')->delete($post->img1);
            $post->img1 = null;
        }

        $post->save();
    }
}
