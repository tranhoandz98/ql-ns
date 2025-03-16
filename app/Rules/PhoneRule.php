<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class PhoneRule implements ValidationRule
{
    private ?string $custom_attribute = null;

    public function customAttribute(string $attribute): self
    {
        $this->custom_attribute = $attribute;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $display_name = $this->custom_attribute ?? $attribute;

        if (is_null($value)) {
            return;
        }

        if (!is_string($value) || strlen($value) < 9 || strlen($value) > 15) {
            $fail(trans('validation.phone_length', ['attribute' => $display_name]));
        }
    }
}
