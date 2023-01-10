<?php

namespace App\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var \Kutia\Larafirebase\FirebaseMessage $message */
        $fcm = $notification->toFirebase($notifiable);
        Http::withHeaders([
            'Authorization' => 'key=' . env('FIREBASE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post("https://fcm.googleapis.com/fcm/send", [
            "registration_ids" => [$notifiable->fcm_token],
            "notification" => [
                "title" => $fcm['title'],
                "body" => $fcm['body'],
            ]
        ]);
    }
}
