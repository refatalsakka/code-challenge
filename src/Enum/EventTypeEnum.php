<?php

namespace App\Enum;

enum EventTypeEnum: string
{
    case REGISTRATION = 'registration';
    case VISIT = 'visit';

    public const VALUES = [
        self::REGISTRATION->value,
        self::VISIT->value,
    ];
}
