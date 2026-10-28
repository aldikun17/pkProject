<?php

use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/event/category', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'category'])->middleware(['auth', 'verified'])->name('event.category');
Route::get('/health/events', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'events'])->middleware(['auth', 'verified'])->name('health.events');
Route::get('/event/reports', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'reports'])->middleware(['auth', 'verified'])->name('event.reports');
//Route::post('/sign/out', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'signout'])->middleware(['auth', 'verified'])->name('auth.sign.out');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post("/event-category/store", [CategoryController::class, "store"])->name("event_category.store");
Route::put("/event-category/update/{id}", [CategoryController::class, "update"])->name("event_category.update");
Route::delete("/event-category/delete/{id}", [CategoryController::class, "destroy"])->name("event_category.delete");


require __DIR__ . '/auth.php';
