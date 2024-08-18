<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TaskModeratingNotice extends Notification
{
    use Queueable;

    /**
     * @var Task
     */
    private Task $task;

    /**
     * @var User
     */
    private User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, User $user)
    {
        $this->task = $task;

        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * @param $notifiable
     */
    public function toTelegram($notifiable): TelegramMessage
    {
        return TelegramMessage::create()
            ->to($this->user->resource->telegram_id)
            ->content("Задача #{$this->task->id} была отправлена на модерацию. Пожалуйста, проверьте задачу.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
