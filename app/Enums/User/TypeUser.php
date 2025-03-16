<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum TypeUser: int
{
    case ADMIN = 1;
    case CAN_BO_QUAN_LY = 2;
    case NHAN_VIEN = 3;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => Lang::get("messages.admin"),
            self::CAN_BO_QUAN_LY => Lang::get("messages.management_staff"),
            self::NHAN_VIEN => Lang::get("messages.staff"),
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->label(),
            'color' => match ($case) {
                self::ADMIN => 'success',
                self::CAN_BO_QUAN_LY => 'success',
                self::NHAN_VIEN => 'secondary',
            },
        ], self::cases());
    }
}
