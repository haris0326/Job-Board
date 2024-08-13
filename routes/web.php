<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Jobs\JobsController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Admins\AdminsController;
use App\Http\Controllers\Categories\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');


Route::get('/job', [HomeController::class, 'show'])->name('job.show');

Route::group(['prefix' => 'jobs'], function () {

Route::get('single/{id}', [JobsController::class, 'single'])->name('single.job');
Route::post('save', [JobsController::class, 'saveJob'])->name('save.job');
Route::post('apply', [JobsController::class, 'jobApply'])->name('apply.job');
Route::any('search', [JobsController::class, 'search'])->name('search.job');
});

Route::group(['prefix' => 'categories'], function () {
Route::get('single/{name}', [CategoriesController::class, 'singleCategories'])->name('categories.single');
});


Route::group(['prefix' => 'users'], function () {
Route::get('profile', [UsersController::class, 'profile'])->name('profile');
Route::get('applications', [UsersController::class, 'applications'])->name('applications');

Route::get('savedjobs', [UsersController::class, 'savedJobs'])->name('saved.jobs');

Route::get('edit-details', [UsersController::class, 'editDetails'])->name('edit.details');
Route::post('edit-details', [UsersController::class, 'updateDetails'])->name('update.details');

Route::get('edit-cv', [UsersController::class, 'editCV'])->name('edit.cv');
Route::post('edit-cv', [UsersController::class, 'updateCV'])->name('update.cv');
});


// Route::get('admin/login', [AdminsController::class, 'viewLogin'])->name('view.login')->middleware('CheckForAuth');
Route::get('admin/login', [AdminsController::class, 'viewLogin'])->name('view.login');  // Remove middleware for login route


Route::post('admin/login', [AdminsController::class, 'checkLogin'])->name('check.login');


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    
    Route::get('/', [AdminsController::class, 'index'])->name('admin.dashboard');
    Route::get('/all-admins', [AdminsController::class, 'admins'])->name('view.admins');

    // Create New Admin

    Route::get('/create-admins', [AdminsController::class, 'createAdmins'])->name('create.admins');
    Route::post('/create-admins', [AdminsController::class, 'storeAdmins'])->name('store.admins');

    // Show Categories
    Route::get('/display-categories', [AdminsController::class, 'displayCategories'])->name('display.categories');

    // Create category
    Route::get('/create-cates', [AdminsController::class, 'createCategories'])->name('create.categories');
    Route::post('/create-cates', [AdminsController::class, 'storeCategories'])->name('store.categories');

    //Update category
    Route::get('/edit-cates/{id}', [AdminsController::class, 'editCategories'])->name('edit.categories');
    Route::put('/edit-cates/{id}', [AdminsController::class, 'updateCategories'])->name('update.categories');
    Route::delete('/delete-cates/{id}', [AdminsController::class, 'deleteCategory'])->name('delete.category');

    //Jobs
    Route::get('/display-jobs', [AdminsController::class, 'allJobs'])->name('display.jobs');
    Route::get('/create-jobs', [AdminsController::class, 'createJobs'])->name('create.jobs');
    Route::post('/create-jobs', [AdminsController::class, 'storeJobs'])->name('store.jobs');

    Route::delete('/delete-jobs/{id}', [AdminsController::class, 'deleteJobs'])->name('delete.jobs');

    //Applications
    Route::get('/apps-jobs', [AdminsController::class, 'DisplayApps'])->name('display.apps');
    Route::delete('/delete-apps/{id}', [AdminsController::class, 'deleteApps'])->name('delete.apps');

    Route::post('admin/logout', [AdminsController::class, 'adminLogout'])->name('admin.logout');


});

