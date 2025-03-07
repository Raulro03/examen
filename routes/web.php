<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PageCourseDetailsController;
use App\Http\Controllers\PageDashboardController;
use App\Http\Controllers\PageHomeController;
use App\Http\Controllers\PageVideosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', PageHomeController::class)->name('pages.home');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin_dashboard', AdminDashboardController::class)->name('pages.admin-dashboard');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client_dashboard', PageDashboardController::class)->name('pages.client-dashboard');
});


Route::get('/dashboard', function () {
    return redirect(auth()->user()->role === 'admin'
        ? route('pages.admin-dashboard')
        : route('pages.client-dashboard'));
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth' ,'role:admin'])->group(function () {
    Route::resource('courses', CourseController::class);

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('courses/{course:slug}', PageCourseDetailsController::class)->name('pages.course-details');
    Route::get('videos/{course:slug}/{video:slug?}', PageVideosController::class)
        ->name('pages.course-videos');
});

Route::webhooks('webhooks');
