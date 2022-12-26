<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;

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

Route::middleware('auth')->group(function () {
    /* Dashboard */
    Route::view('/', 'dashboard')->name('dashboard')->middleware('auth');

    /* Roles management */
    Route::resource('roles', RoleController::class);

    /* Users management */
    Route::resource('users', UserController::class);

    /* Assignments management */
    Route::resource('assignments', AssignmentController::class);

    /* Students submissions to assignment */
    Route::get('assignment/{assignment}/submit', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('assignment/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('assignment/{assignment}/submission', [SubmissionController::class, 'show'])->name('submissions.show');
});
