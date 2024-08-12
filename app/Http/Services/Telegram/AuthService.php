<?php

namespace App\Http\Services\Telegram;

use App\Models\AuthUserResource;
use App\Models\User;

class AuthService
{
    private User $userModel;
    private AuthUserResource $authUserResourceModel;
    private NotificationService $notificationService;

    public function __construct()
    {
        $this->userModel = new User();
        $this->authUserResourceModel = new AuthUserResource();
        $this->notificationService = new NotificationService();
    }

    /**
     * @param int $telegramID
     * @return mixed
     */
    public function getTokenByTelegramId(int $telegramID) : mixed
    {
        $resource = $this->authUserResourceModel->where('telegram_id', $telegramID)
            ->with('user')
            ->first();

        if ($resource) {
            return auth('api')->fromUser($resource->user);
        }

        return false;
    }

    /**
     * @param array $registerData
     * @return array
     */
    public function register(array $registerData)
    {
        $user = new User();
        $user->name = $registerData['name'];
        $user->specialty = $registerData['specialty'];
        $user->description = $registerData['description'];
        $user->email = $registerData['email'];
        $user->save();

        $resource = new AuthUserResource();
        $resource->telegram_id = $registerData['telegram_id'];
        $resource->user_id = $user->id;
        $resource->save();

        $this->notificationService->greeting($user, [
            'message' => 'asd'
        ]);

        return [
            'user' => $user,
            'resource' => $resource,
            'token' => auth('api')->fromUser($user)
        ];
    }

}
