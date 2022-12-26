<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Mail\MonthlyReport;

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

    /* Mark notification read */
    Route::post('notifications/{id}', function ($id) {
        Auth::user()->notifications()->find($id)->markAsRead();
        return redirect()->back();
    })->name('notifications.read');

    /* Roles management */
    Route::resource('roles', RoleController::class);

    /* Users management */
    Route::resource('users', UserController::class);

    /* Assignments management */
    Route::resource('assignments', AssignmentController::class);

    /* Students submissions to assignment */
    Route::get('submissions', [SubmissionController::class, 'index'])->name('submissions.index'); // List my submissions
    Route::get('submissions/{submission}', [SubmissionController::class, 'edit'])->name('submissions.edit'); // Give degree by teacher
    Route::put('submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update'); // Give degree by teacher
    Route::get('assignment/{assignment}/submit', [SubmissionController::class, 'create'])->name('submissions.create'); // Submit submission
    Route::post('assignment/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store'); // Submit submission
    Route::get('assignment/{assignment}/submission', [SubmissionController::class, 'show'])->name('submissions.show'); // Show my submission
});
