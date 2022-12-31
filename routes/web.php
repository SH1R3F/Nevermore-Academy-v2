<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\MobileVerificationController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\NotificationController;
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

/* Mobile verification routes */
//
Route::middleware('auth')->group(function () {
    // Mobile verification
    Route::get('verify-mobile', [MobileVerificationController::class, 'showVerifyForm'])->name('verify-mobile.notice');
    Route::post('verify-mobile', [MobileVerificationController::class, 'verify'])->name('verify-mobile.verify')->middleware('throttle:6,1');
    Route::get('verify-mobile/resend', [MobileVerificationController::class, 'resend'])->name('verify-mobile.resend')->middleware('throttle:6,1');

    // 2 Factor Authentication
    Route::get('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'showChooseForm'])->name('2fa.choose');
    Route::post('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'send'])->name('2fa.send');
    Route::get('/two-factor-authentication/verify', [TwoFactorAuthenticationController::class, 'showVerifyForm'])->name('2fa.notice');
    Route::post('/two-factor-authentication/verify', [TwoFactorAuthenticationController::class, 'verify'])->name('2fa.verify');
    Route::get('/two-factor-authentication/resend', [TwoFactorAuthenticationController::class, 'resend'])->name('2fa.resend');
});


Route::middleware(['auth', 'mobile-verified', '2fa'])->group(function () {
    /* Dashboard */
    Route::view('/', 'dashboard')->name('dashboard');

    /* Mark notification read */
    Route::post('notifications/{id}', function ($id) {
        Auth::user()->notifications()->find($id)->markAsRead();
        return redirect()->back();
    })->name('notifications.read');

    /* Notifications management */
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/push-notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/push-notifications/create', [NotificationController::class, 'store'])->name('notifications.store');
    });

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
