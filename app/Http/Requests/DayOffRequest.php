<?php

namespace App\Http\Requests;

use App\Enums\DayOff\TypeDayOffEnum;
use App\Models\DayOffs;
use App\Models\DayOffsUser;
use App\Models\Departments;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class DayOffRequest extends FormRequest
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
        $rules = [
            'user_id' => [
                'required_if:id,null',
            ],
            'type' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === TypeDayOffEnum::ON_LEAVE->value) {
                        $userId = $this->input('user_id');
                        $id = $this->input('id');
                        if ($id) {
                            $dayOff = DayOffs::find($id);
                            $userId = $dayOff->user_id;
                        }

                        $availableDays = DayOffsUser::where('user_id', $userId)
                            ->whereYear('start_at', now()->year)
                            ->first();

                        if (!$availableDays) {
                            $fail(Lang::get('messages.day_off-leave_day') . ' ' . Lang::get('messages.not_found'));
                        } else {
                            if ($availableDays->remaining_leave - $this->input('num') < 0) {
                                $fail(Lang::get('messages.day_off-type') . ' ' . Lang::get('messages.not_valid'));
                            }
                        }
                    }
                },
            ],
            'start_at' => 'required',
            'description' => 'max:1000',

        ];

        if ($this->request->get('half_day')) {
            $rules['session'] = [
                'required',
            ];
        } else {
            $rules['end_at'] = [
                'required',
                'after_or_equal:start_at',
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id' => Lang::get('messages.day_off-user_id'),
            'type' => Lang::get('messages.day_off-type'),
            'start_at' => Lang::get('messages.day_off-start_at'),
            'end_at' => Lang::get('messages.day_off-end_at'),
            'description' => Lang::get('messages.description'),
            'session' => Lang::get('messages.day_off-session'),
        ];
    }

    public function filters()
    {
        return [];
    }
}
