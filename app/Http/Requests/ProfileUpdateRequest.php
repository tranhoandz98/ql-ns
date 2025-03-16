<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique(User::class)->ignore($this->id),
            ],
            'phone' => [
                'max:15',
                (new PhoneRule())->customAttribute(Lang::get('messages.user-phone')),
            ],
            'fileAvatar' => 'image|mimes:jpe,png,jpg|max:1024',
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
    }

    public function attributes()
    {
        return [
            'name' => Lang::get('messages.user-name'),
            'status' => Lang::get('messages.user-status'),
            'type' => Lang::get('messages.user-type'),
            'email' => Lang::get('messages.user-email'),
            'position_id' => Lang::get('messages.user-position_id'),
            'department_id' => Lang::get('messages.user-department_id'),
            'role_id' => Lang::get('messages.user-role_id'),
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
            'fileAvatar' => Lang::get('messages.user-avatar'),
        ];
    }
}
