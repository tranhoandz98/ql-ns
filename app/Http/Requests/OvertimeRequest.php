<?php

namespace App\Http\Requests;

use App\Models\Departments;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class OvertimeRequest extends FormRequest
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
            'type' => 'required',
            'expected_start' => 'required_if:id,null|date_format:d/m/Y H:i',
            'expected_end' => ['required_if:id,null', 'date_format:d/m/Y H:i', 'after:expected_start'],
            'actual_start' => 'nullable|date_format:d/m/Y H:i',
            'actual_end' => 'nullable|date_format:d/m/Y H:i|after:actual_start',
            'content' => 'required|max:1000',
            'work_results' => 'max:1000',
            'note' => 'max:1000',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id' => Lang::get('messages.overtime-user_id'),
            'type' => Lang::get('messages.overtime-type'),
            'expected_start' => Lang::get('messages.overtime-expected_start'),
            'expected_end' => Lang::get('messages.overtime-expected_end'),
            'actual_start' => Lang::get('messages.overtime-actual_start'),
            'actual_end' => Lang::get('messages.overtime-actual_end'),
            'content' => Lang::get('messages.overtime-content'),
            'work_results' => Lang::get('messages.overtime-work_results'),
            'note' => Lang::get('messages.note'),
        ];
    }

    public function filters()
    {
        return [];
    }
}
