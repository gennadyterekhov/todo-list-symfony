<?php

namespace App\Enum;

enum Status: string
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Done = 'done';
}
