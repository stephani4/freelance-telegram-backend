<?php

namespace App\Http\Controllers\Api\Auth\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\NotificationService;
use App\Http\Services\Telegram\UserService;
use Illuminate\Http\Request;

class RegisterProfileController extends Controller
{
    private UserService $userService;

    private NotificationService $notificationService;

    public function __construct(UserService $userService, NotificationService $notificationService)
    {
        $this->userService = $userService;

        $this->notificationService = $notificationService;
    }

    /**
     * Регистрация профиля пользователя через Telegram
     *
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request): mixed
    {
        $authed = auth('api')->user();
        $this
            ->userService
            ->registerFromTelegram(
                $authed ? $authed->resource->telegram_id : $request->get('id'),
                $request->all()
            );

        // Уведомление об успешной регистрации
        $this->notificationService->greeting(
            $this->userService->getUser()
        );

        return response()->json([
            'message' => $authed ? 'Пользователь успешно сохранен' : 'Профиль успешно создан',
            'status' => 'success'
        ], $authed ? 200 : 201);
    }
}
