<?php

namespace App\Enums\User;

enum TimeWorkUserEnum: string
{
    case EIGHT = "08:00:00";
    case EIGHT_PART = "08:30:00";

    public function label(): string
    {
        return match ($this) {
            self::EIGHT => "08:00:00",
            self::EIGHT_PART => "08:30:00",
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'name' => $case->label(),
        ], self::cases());
    }
}
