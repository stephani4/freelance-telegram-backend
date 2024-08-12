<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\NotificationService;

class LoadNotificationsController extends Controller
{
    private NotificationService $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    public function current()
    {
        $user = auth('api')->user();
        $notifications = $this->notificationService->getNotificationsByUser($user);

        return response()->json([
            'status' => 'success',
            'notifications' => $notifications,
            'time' => date('Y-m-d H:i:s')
        ]);
    }
}
