<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AmenitiesController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter/subscribe', [ContactController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms-of-service');
Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');


Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Authenticated admin routes
//    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/create', [AdminProjectController::class, 'create'])->name('projects.create');
        Route::get('/projects/{project}/edit', [AdminProjectController::class, 'edit']);
        Route::put('/projects/{project}', [AdminProjectController::class, 'update'])->name('projects.update');
        Route::post('/projects/{project}/delete', [AdminProjectController::class, 'destroy']);
        Route::post('/projects', [AdminProjectController::class, 'store']);
//        Route::post('/projects', [AdminProjectController::class, 'update']);

        Route::post('projects/upload-images', [AdminProjectController::class, 'uploadImages'])->name('projects.upload-images') ;
        Route::post('projects/{project}/delete-image', [AdminProjectController::class, 'deleteImage'])->name('projects.upload-images') ;


        Route::get('/amenities', [AmenitiesController::class, 'index'])
            ->name('amenities.index');

        Route::post('/amenities/store', [AmenitiesController::class, 'store'])
            ->name('amenities.store');

        Route::post('/amenities/{amenity}/update', [AmenitiesController::class, 'update'])
            ->name('amenities.update');

        Route::delete('/amenities/{amenity}', [AmenitiesController::class, 'destroy'])
            ->name('amenities.destroy');
//    });
});
