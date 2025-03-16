<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum StatusUser: int
{
    case DANG_LAM_VIEC = 1;
    case HOP_DONG_DA_CHAM_DUT = 2;
    case TAM_NGHI = 3;
    case THAI_SAN = 4;

    public function label(): string
    {
        return match ($this) {
            self::DANG_LAM_VIEC => Lang::get("messages.working"),
            self::HOP_DONG_DA_CHAM_DUT => Lang::get("messages.inactivity"),
            self::TAM_NGHI =>Lang::get("messages.take_a_break"),
            self::THAI_SAN => Lang::get("messages.maternity"),
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->label(),
            'color' => match ($case) {
                self::DANG_LAM_VIEC => 'success',
                self::HOP_DONG_DA_CHAM_DUT => 'danger',
                self::TAM_NGHI => 'warning',
                self::THAI_SAN => 'warning',
            },
        ], self::cases());
    }
}
