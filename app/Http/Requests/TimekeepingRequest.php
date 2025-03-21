<?php

namespace App\Http\Requests;

use App\Models\Timekeeping; // Ensure to import the Timekeeping model
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class TimekeepingRequest extends FormRequest
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
            'checkout' => 'required|date_format:d/m/Y H:i|before_or_equal:' . now(),
            // Custom validation rule to check for existing checkin on the same day for the same user
            'checkin' => [
                'required',
                'date_format:d/m/Y H:i',
                'before_or_equal:'.now(),
                function ($attribute, $value, $fail) {
                    $date = \Carbon\Carbon::createFromFormat('d/m/Y H:i',$value)->format('Y-m-d');
                    $userId = $this->input('user_id');

                    $exists = Timekeeping::where('user_id', $userId)
                        ->whereDate('checkin', $date)
                        ->exists();

                    if ($exists) {
                        $fail(
                            Lang::get('messages.timekeeping-checkin')
                                . ' ' . Lang::get('messages.unique')
                        );
                    }
                },
            ],
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id' => Lang::get('messages.timekeeping-user_id'),
            'checkin' => Lang::get('messages.timekeeping-checkin'),
            'checkout' => Lang::get('messages.timekeeping-checkout'),
        ];
    }

    public function filters()
    {
        return [];
    }
}
