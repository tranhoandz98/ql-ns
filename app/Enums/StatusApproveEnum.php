<?php

namespace App\Enums;

use Illuminate\Support\Facades\Lang;

enum StatusApproveEnum: string
{
    case DRAFT = 'DRAFT';
    case WAIT_MANAGER = 'WAIT_MANAGER';
    case DONE = 'DONE';
    case REJECT = 'REJECT';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => Lang::get("messages.draft"),
            self::WAIT_MANAGER => Lang::get("messages.wait_manager"),
            self::DONE =>Lang::get("messages.done"),
            self::REJECT => Lang::get("messages.reject"),
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->label(),
            'color' => match ($case) {
                self::DRAFT => 'secondary',
                self::WAIT_MANAGER => 'warning',
                self::DONE => 'success',
                self::REJECT => 'danger',
            },
        ], self::cases());
    }
}
