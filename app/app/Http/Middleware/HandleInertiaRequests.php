<?php

namespace App\Http\Middleware;

use App\Enum\UserEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

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
     * @param Request $request
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
     * @param Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info'),
            ],
            'auth' => [
                'user' => $request->user(),
                'role' => $request->user()
                    ? $request->user()->role
                    : '',
            ],
            'app' => [
                'name' => config('app.name'),
                'perpage' => [
                    ['label' => '5', 'value' => 5],
                    ['label' => '10', 'value' => 10],
                    ['label' => '20', 'value' => 20],
                    ['label' => '50', 'value' => 50],
                    ['label' => '100', 'value' => 100],
                ],
            ],
            'locale' => function () {
                if(session()->has('locale')) {
                    app()->setLocale(session('locale'));
                }
                return app()->getLocale();
            },
            'language' => function () {
                $path = lang_path() . '/' . app()->getLocale();
                $allTranslations = collect(File::allFiles($path))->flatMap(function ($file) {
                    return [
                        ($translation = $file->getBasename('.php')) => trans($translation,array(),null),
                    ];
                });
                return response()->json($allTranslations);
            },
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                    'query'=>$request->query(),
                ]);
            },
            'provinces' => \App\Models\Address\Province::all(),
            'districts' => \App\Models\Address\District::all(),
            'wards'     => \App\Models\Address\Ward::all(),
            'categories' => \App\Models\Category::all(),
            'user_role' => [
                 'admin'    => UserEnum::ROLE_ADMIN,
                 'lessor'   => UserEnum::ROLE_LESSOR,
                 'lessee'   => UserEnum::ROLE_LESSEE,
            ],
            // 'user_notifications' => fn () => auth()->user() ? $notifications = auth()->user()
            //         ->notifications
            //         ->sortBy('created_at')
            //         ->where('type', 'App\Notifications\UserNotification')
            //         ->all() : [],
            // 'teacher_notifications' => fn () => auth()->user() ? $notifications = auth()->user()
            //         ->notifications
            //         ->sortBy('created_at')
            //         ->where('type', 'App\Notifications\TeacherNotification')
            //         ->all() : [],
        ]);
    }
}
