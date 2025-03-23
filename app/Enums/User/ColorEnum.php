<?php

namespace App\Enums\User;

enum ColorEnum: string
{
    case WARNING = 'warning';
    case SUCCESS = 'success';
    case DANGER = 'danger';
    case SECONDARY = 'secondary';
    case INFO = 'info';

    public function label(): string
    {
        return match ($this) {
            self::WARNING => 'warning',
            self::SUCCESS => 'success',
            self::DANGER => 'danger',
            self::SECONDARY => 'secondary',
            self::INFO => 'info',
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
