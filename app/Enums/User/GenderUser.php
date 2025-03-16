<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum GenderUser: int
{
    case MALE = 1;
    case FEMALE = 2;
    case OTHER = 3;

    public function label(): string
    {
        return match ($this) {
            self::MALE => Lang::get("messages.male"),
            self::FEMALE => Lang::get("messages.female"),
            self::OTHER => Lang::get("messages.other"),
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
