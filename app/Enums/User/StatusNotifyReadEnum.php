<?php

namespace App\Enums\User;

use Illuminate\Support\Facades\Lang;

enum StatusNotifyReadEnum: string
{
    case UNREAD = 'UNREAD';
    case READ = 'READ';

    public function label(): string
    {
        return match ($this) {
            self::UNREAD => Lang::get("messages.notification-un_read"),
            self::READ => Lang::get("messages.notification-read"),
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->label(),
            'color' => $case === self::UNREAD ? 'secondary' : 'success',
        ], self::cases());
    }
}
