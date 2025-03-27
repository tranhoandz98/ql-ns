<?php

namespace App\Http\Requests;

use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class SalaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        if ($this->input("id")) {
        } else {
            $rules["user_id"] = [
                "required",
                function ($attribute, $value, $fail) {
                    $dateNow = Carbon::now()->format('m/y');

                    $exists = Salary::where('user_id', $value)
                        ->whereMonth('start_at', $dateNow)->exists();

                    if ($exists) {
                        $fail(
                            Lang::get('messages.salary-user_id')
                                . ' ' . Lang::get('messages.unique')
                        );
                    }
                },
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id' => Lang::get('messages.user_id'),
        ];
    }

    public function filters()
    {
        return [];
    }
}
