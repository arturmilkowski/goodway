<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\Admin\Page\{PageController, ImgController as PageImgController};
use App\Http\Controllers\Admin\Blog\Post\{PostController, ImgController as PostImgController};


Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('admin/pages', PageController::class)->names('admin.pages');
    Route::delete('admin/pages/images/{page}', PageImgController::class)->name('admin.pages.images.destroy');

    Route::resource('admin/blog/posts', PostController::class)->names('admin.blog.posts');
    Route::delete('admin/blog/posts/images/{post}', PostImgController::class)->name('admin.blog.posts.images.destroy');
});

require __DIR__ . '/settings.php';
