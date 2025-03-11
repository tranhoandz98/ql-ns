<?php

namespace App\Enums\User;

enum TypeUser: int
{
    case ADMIN = 1;
    case CAN_BO_QUAN_LY = 2;
    case NHAN_VIEN = 3;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::CAN_BO_QUAN_LY => 'Cán bộ quản lý',
            self::NHAN_VIEN => 'Nhân viên',
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
