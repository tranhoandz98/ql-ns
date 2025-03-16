<?php

namespace App\Http\Requests;

use App\Models\Departments;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
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
            'name' => [
                'required',
                'max:255',
                Rule::unique(Departments::class)->ignore($this->id),
            ],
            'description' => 'max:1000',
            'manager_id' => 'required',
            'phone' => [
                'max:15',
                (new PhoneRule())->customAttribute(Lang::get('messages.user-phone')),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
            ],
            'status' => 'required',
            'founding_at' => 'required',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => Lang::get('messages.department-name'),
            'description' => Lang::get('messages.description'),
            'manager_id' => Lang::get('messages.department-manager_id'),
            'status' => Lang::get('messages.status'),
            'founding_at' => Lang::get('messages.department-founding_at'),
            'email' => Lang::get('messages.email'),
            'phone' => Lang::get('messages.phone'),
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim',
        ];
    }
}
