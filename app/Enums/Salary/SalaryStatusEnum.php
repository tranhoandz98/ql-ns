<?php

namespace App\Enums\Salary;

use Illuminate\Support\Facades\Lang;

enum SalaryStatusEnum: string
{
    case DRAFT = 'DRAFT';
    case DONE = 'DONE';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => Lang::get("messages.draft"),
            self::DONE =>Lang::get("messages.done"),
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'id' => $case->value,
            'name' => $case->label(),
            'color' => match ($case) {
                self::DRAFT => 'secondary',
                self::DONE => 'success',
            },
        ], self::cases());
    }
}
