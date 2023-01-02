<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\PushNotificationToUsers;
use App\Http\Requests\PushNotificationRequest;

class NotificationController extends Controller
{
    public function store(PushNotificationRequest $request, PushNotificationToUsers $action)
    {
        $action->handle($request->validated());

        return $this->apiResponse(__('Notification has been sent successfully!'));
    }
}
