<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class RoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name,'.$this->id.'|max:255',
            'permission' => 'required',
            'description' => 'max:2000',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => Lang::get('messages.role-name'),
            'permission' => Lang::get('messages.role-permission'),
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
