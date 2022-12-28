<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\PushNotificationToUsers;
use App\Http\Requests\PushNotificationRequest;

class NotificationController extends Controller
{
    public function create()
    {
        return view('notifications.create');
    }

    public function store(PushNotificationRequest $request, PushNotificationToUsers $action)
    {
        $action->handle($request->validated());

        return redirect()->back()->with('status', 'Notification has been sent successfully!');
    }
}
