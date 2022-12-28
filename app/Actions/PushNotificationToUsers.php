<?php

namespace App\Actions;

use App\Models\Role;
use App\Models\User;
use App\Notifications\PushAlert;
use NotificationChannels\Twilio\TwilioChannel;
use Illuminate\Support\Facades\Notification;

class PushNotificationToUsers
{

    public function handle(array $data)
    {
        $roles = $data['recipients'];

        $data['via'] = array_map(function ($channel) {
            if ($channel === 'sms') {
                return TwilioChannel::class;
            }
            return $channel;
        }, $data['via']);

        $ids = Role::whereIn('name', $roles)->pluck('id');
        $users = User::whereIn('role_id', $ids)->get();

        Notification::send($users, new PushAlert($data));
    }
}
