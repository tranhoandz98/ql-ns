<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class UserRequest extends FormRequest
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
            'email' => 'required|unique:users,email,' . $this->id . '|max:150',
            'name' => 'required|max:255',
            'position_id' => 'required',
            'department_id' => 'required',
            'phone' => 'max:15',
            'person_tax_code' => 'max:255',
            'identifier' => 'max:255',
            'place_of_issue' => 'max:255',
            'nationality' => 'max:255',
            'nation' => 'max:255',
            'current_address' => 'max:500',
            'permanent_address' => 'max:500',
            'bank_account' => 'max:255',
            'bank' => 'max:255',
            'bank_branch' => 'max:255',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => Lang::get('messages.user-name'),
            'email' => Lang::get('messages.user-email'),
            'position_id' => Lang::get('messages.user-position_id'),
            'department_id' => Lang::get('messages.user-department_id'),
            'phone' => Lang::get('messages.user-phone'),
            'person_tax_code' => Lang::get('messages.user-person_tax_code'),
            'identifier' => Lang::get('messages.user-identifier'),
            'place_of_issue' => Lang::get('messages.user-place_of_issue'),
            'nationality' => Lang::get('messages.user-nationality'),
            'nation' => Lang::get('messages.user-nation'),
            'current_address' => Lang::get('messages.user-current_address'),
            'permanent_address' => Lang::get('messages.user-permanent_address'),
            'bank_account' => Lang::get('messages.user-bank_account'),
            'bank' => Lang::get('messages.user-bank'),
            'bank_branch' => Lang::get('messages.user-bank_branch'),
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim',
        ];
    }
}
