<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum TypeOvertimeEnum: string
{
    case DAY_OF_THE_WEEK = 'DAY_OF_THE_WEEK';
    case DAY_OFF = 'DAY_OFF';
    case HOLIDAY = 'HOLIDAY';

    public function label(): string
    {
        return match ($this) {
            self::DAY_OF_THE_WEEK => Lang::get("messages.day_of_the_week"),
            self::DAY_OFF => Lang::get("messages.day_off"),
            self::HOLIDAY =>Lang::get("messages.holiday"),
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
