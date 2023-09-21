<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Notifications\TeacherNotification;
use App\Notifications\UserNotification;
use Pusher\Pusher;
use App\Models\Notification;
use App\Services\NotificationService;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * @param NotificationService $notificationService
     */
    public function __construct(
        public NotificationService $notificationService,
    )
    {

    }

    /**
     *
     * @return Response
     */
    public function notificationTeacher(): Response
    {
        $notifications = auth()->user()
            ->notifications
            ->sortBy('created_at')
            ->where('type', 'App\Notifications\TeacherNotification')
            ->all();

        return Inertia::render('Teacher/Notification', [
            'notifications' => $notifications,
            'user'          => auth()->user(),
        ]);
    }

    /**
     * @return Response|RedirectResponse
     */
    public function notificationUser(): Response|RedirectResponse
    {
        if (! auth()->user()) :
            return redirect()->back();
        endif;

        $notifications = auth()->user()
            ->notifications
            ->sortBy('created_at')
            ->where('type', 'App\Notifications\UserNotification')
            ->all();

        return Inertia::render('User/Notification', [
            'notifications' => $notifications,
            'user'          => auth()->user(),
        ]);
    }

    /**
     * @Route apiGet("api/v1/teacher/notification", name="teacher.get.notification")
     * @param Request $request
     * @return JsonResponse
     */
    public function getNotification(Request $request): JsonResponse
    {
        try {
            $notification = Notification::where('id', $request->id)->first();
            $notification->data = json_decode($notification->data);

            return response()->json([
                'notification' => $notification,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to get notification',
            ], 200);
        }
    }

    /**
     * @Route get("/notification/detail, name="notification.detail")
     * @param Request $request
     * @return RedirectResponse
     */
    public function notificationDetail(Request $request): RedirectResponse
    {
        $noti = Notification::where('id', $request->notification['id'])
            ->update(['read_at' => Carbon::now()]);
        $routeName = app('router')
            ->getRoutes()
            ->match(app('request')
            ->create($request->notification['data']['target'], 'GET'))
            ->getName();
        $arrRoute = explode("/", $request->notification['data']['target']);
        if ((int) end($arrRoute) !== 0) :
            return redirect()->route($routeName, ['id' => end($arrRoute)]);
        endif;

        return redirect()->route($routeName);
    }
}
