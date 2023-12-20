<?php

namespace App\Services;

use App\Notifications\TeacherNotification;
use App\Notifications\UserNotification;
use App\Constants\NotificationConstants;
use Pusher\Pusher;

class NotificationService
{
    /**
     * @param object|null $object
     * @param array $data
     * @param string $target
     * @return void
     */
    public function sendNotification(?object $object, $data = [], $target = '')
    {
        if ($object) {
            if ($target == NotificationConstants::BROADCAST_TEACHER) :
                $object->notify(new TeacherNotification($data));
            else :
                $object->notify(new UserNotification($data));
            endif;

            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );

            $pusher = new Pusher(
                config('app.pusher_app_key'),
                config('app.pusher_app_secret'),
                config('app.pusher_app_id'),
                $options
            );

            $pusher->trigger('NotificationEvent', $target, $data);
        }
    }
}
