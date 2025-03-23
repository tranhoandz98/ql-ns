<?php

namespace App\Enums\DayOff;

use Illuminate\Support\Facades\Lang;

enum TypeDayOffEnum: string
{
    case LEAVE_WITHOUT_PAY = 'leave_without_pay';
    case ON_LEAVE = 'on_leave';

    public function label(): string
    {
        return match ($this) {
            self::LEAVE_WITHOUT_PAY => Lang::get("messages.leave_without_pay"),
            self::ON_LEAVE => Lang::get("messages.on_leave"),
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
