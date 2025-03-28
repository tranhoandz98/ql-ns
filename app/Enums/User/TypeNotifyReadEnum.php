<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum TypeNotifyReadEnum: string
{
    case OVERTIME_APPROVAL = 'overtime_approval';
    case DAY_OFF = 'day_off';
    case KPI = 'KPI';
    case SALARY = 'salary';

    public function label(): string
    {
        return match ($this) {
            self::OVERTIME_APPROVAL => Lang::get("notification-overtime_approval"),
            self::DAY_OFF => Lang::get("notification-day_off"),
            self::KPI => 'KPI',
            self::SALARY => 'KPI',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->label(),
            'icon' => match ($case) {
                self::OVERTIME_APPROVAL => 'clock-plus',
                self::DAY_OFF => 'calendar-cancel',
                self::KPI => 'cookie',
                self::SALARY => 'user-dollar',
            },
        ], self::cases());
    }
}
