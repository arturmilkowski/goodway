<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\Admin\Page\{PageController as AdminPageController, ImgController as AdminPageImgController};
use App\Http\Controllers\Admin\Blog\Post\{PostController as AdminPostController, ImgController as AdminPostImgController};
use App\Http\Controllers\Admin\Project\{ProjectController as AdminProjectController, ImgController as AdminProjectImgController};
use App\Http\Controllers\Blog\Post\PostController;
use App\Http\Controllers\Project\ProjectController;

Route::prefix('{locale}')
    ->whereIn('locale', config('settings.locales', ['pl', 'en']))
    ->middleware('locale')
    ->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('home');
        Route::get('/aktualnosci/{slug}', PostController::class)->name('blog.posts.show');
        Route::get('/projekty/{slug}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
    });

// Przekierowanie z '/' na domyślny język
Route::get('/', fn() => redirect()->route('home', ['locale' => config('app.locale', 'pl')]));

// --- Panel admina ---
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('admin/pages', AdminPageController::class)->names('admin.pages');
    Route::delete('admin/pages/images/{page}', AdminPageImgController::class)->name('admin.pages.images.destroy');

    Route::resource('admin/blog/posts', AdminPostController::class)->names('admin.blog.posts');
    Route::delete('admin/blog/posts/images/{post}', AdminPostImgController::class)->name('admin.blog.posts.images.destroy');

    Route::resource('admin/projects', AdminProjectController::class)->names('admin.projects');
    Route::delete('admin/projects/images/{project}', AdminProjectImgController::class)->name('admin.projects.images.destroy');
});


require __DIR__ . '/settings.php';
