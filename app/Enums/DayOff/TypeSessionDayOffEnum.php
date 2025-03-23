<?php

namespace App\Enums\DayOff;

use Illuminate\Support\Facades\Lang;

enum TypeSessionDayOffEnum: string
{
    case MORNING = 'morning';
    case AFTERNOON = 'afternoon';

    public function label(): string
    {
        return match ($this) {
            self::MORNING => Lang::get("messages.morning"),
            self::AFTERNOON => Lang::get("messages.afternoon"),
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->label(),
        ], self::cases());
    }
}
