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
            'phone' => [
                'max:15',
                (new PhoneRule())->customAttribute(Lang::get('messages.user-phone')),
            ],
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => Lang::get('messages.position-name'),
            'description' => Lang::get('messages.description'),
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim',
        ];
    }
}
