<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum TypeGroupCheckInEnum: int
{
    case MONTH = 1;
    case YEAR= 2;

    public function label(): string
    {
        return match ($this) {
            self::MONTH => Lang::get("messages.timekeeping-checkin_moth"),
            self::YEAR => Lang::get("messages.timekeeping-checkin_year"),
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
