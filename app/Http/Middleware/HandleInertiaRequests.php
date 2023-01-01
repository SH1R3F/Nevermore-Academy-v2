<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {

        $user = $request->user();
        return array_merge(parent::share($request), [
            'APP_NAME' => config('app.name'),
            'authUser' => !Auth::check() ?: [
                'name' => $user->name,
                'avatar' => $user->getFirstMediaUrl('images'),
                'role' => $user->role?->name,
                'verified' => $user->hasVerifiedEmail(),
                'notifications' => $user->unreadNotifications,
                'can' => [
                    'viewAny_role' => $user->can('viewAny', 'App\Models\Role'),
                    'viewAny_user' => $user->can('viewAny', 'App\Models\User'),
                    'viewAny_assignment' => $user->can('viewAny', 'App\Models\Assignment'),
                    'viewAny_submission' => $user->can('viewAny', 'App\Models\Submission'),
                ]
            ],
            'flash' => [
                'status' => $request->session()->get('status')
            ],
            'locale' => function () {
                return app()->getLocale();
            },
            'language' => function () {
                return translations(
                    base_path('lang/' . app()->getLocale() . '.json')
                );
            },
        ]);
    }
}
