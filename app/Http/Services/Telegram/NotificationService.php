<?php

namespace App\Http\Services\Telegram;

use App\Models\Notice;
use App\Models\User;
use App\Notifications\GreetingNotice;

class NotificationService
{
    const DEFAULT_CHANNEL = 'database';

    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * @param User $user
     * @return void
     */
    public function greeting(User $user) : void
    {
        $user->notify(new GreetingNotice($user));
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function getNotificationsByUser(User $user)
    {
        return $user->notifications;
    }
}
