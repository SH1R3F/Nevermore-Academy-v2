<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\MobileVerificationController;
use App\Http\Controllers\Api\Auth\TwoFactorAuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'ar|en'], 'as' => 'api.'], function () {

    /* Authentication routes */
    Route::prefix('auth')->group(function () {
        // Guest routes
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/register', [RegisterController::class, 'create']);

        // Authenticated routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/user', [LoginController::class, 'user']);
            Route::post('/logout', [LoginController::class, 'logout']);

            // Mobile verification routes
            Route::post('verify-mobile', [MobileVerificationController::class, 'verify'])->name('verify-mobile.verify')->middleware('throttle:6,1');
            Route::post('verify-mobile/resend', [MobileVerificationController::class, 'resend'])->name('verify-mobile.resend')->middleware('throttle:6,1');

            Route::post('/two-factor-authentication/verify', [TwoFactorAuthenticationController::class, 'verify'])->name('2fa.verify');
            Route::post('/two-factor-authentication/send', [TwoFactorAuthenticationController::class, 'send'])->name('2fa.send');
        });
    });

    Route::middleware(['auth:sanctum', 'mobile-verified', '2fa'])->group(function () {
        /* Notifications management */
        Route::post('/push-notifications', [NotificationController::class, 'store'])->middleware('role:superadmin')->name('notifications.store');

        /* Roles management */
        Route::resource('roles', RoleController::class)->except(['create', 'edit']);

        /* Users management */
        Route::resource('users', UserController::class)->except(['create', 'edit']);

        /* Assignments management */
        Route::resource('assignments', AssignmentController::class)->except(['create', 'edit']);

        /* Students submissions to assignment */
        Route::get('submissions', [SubmissionController::class, 'index'])->name('submissions.index'); // List my submissions
        Route::post('assignment/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store'); // Submit submission
        Route::get('assignment/{assignment}/submission', [SubmissionController::class, 'show'])->name('submissions.show'); // Show my submission
        Route::put('submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update'); // Give degree by teacher
    });
});
