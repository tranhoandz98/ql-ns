<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum TypeGroupExpectedStartEnum: string
{
    case MONTH = 'month';
    case YEAR= 'yearn';

    public function label(): string
    {
        return match ($this) {
            self::MONTH => Lang::get("messages.overtime-group_moth"),
            self::YEAR => Lang::get("messages.overtime-group_yearn"),
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
