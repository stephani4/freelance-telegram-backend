<?php

namespace App\Enums;

enum Roles: string
{
    /**
     * Администратор
     */
    case ADMIN = 'admin';

    /**
     * Модерация задач
     */
    case TASK_MODERATOR = 'task_moderator';
}
