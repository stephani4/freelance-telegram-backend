<?php

namespace App\Enums;

enum TaskStatus: string
{
    case DRAFT = 'draft';

    case MODERATE = 'moderate';

    case ACCEPT = 'accept';
}
