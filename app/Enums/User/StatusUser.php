<?php

namespace App\Enums\User;

enum StatusUser: int
{
    case DANG_LAM_VIEC = 1;
    case HOP_DONG_DA_CHAM_DUT = 2;
    case TAM_NGHI = 3;
    case THAI_SAN = 4;

    public function label(): string
    {
        return match ($this) {
            self::DANG_LAM_VIEC => 'Đang làm việc',
            self::HOP_DONG_DA_CHAM_DUT => 'Hợp đồng đã chấm dứt',
            self::TAM_NGHI => 'Tạm nghỉ',
            self::THAI_SAN => 'Thai sản',
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
