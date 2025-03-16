<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum StatusGlobalEnum: int
{
    case HOAT_DONG = 1;
    case NGUNG_HOAT_DONG = 2;

    public function label(): string
    {
        return match ($this) {
            self::HOAT_DONG => Lang::get("messages.active"),
            self::NGUNG_HOAT_DONG => Lang::get("messages.de_active"),
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'name' => $case->label(),
            'color' => match ($case) {
                self::HOAT_DONG => 'success',
                self::NGUNG_HOAT_DONG => 'danger',
            },
        ], self::cases());
    }
}
