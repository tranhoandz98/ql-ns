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

class KPIRequest extends FormRequest
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
            'name' => [
                'required',
            ],
            'start_at' => 'required',
            'end_at' => 'required',
            'description' => 'nullable|max:1000',
            'note' => 'nullable|max:1000',
            'items' => 'required|array', // Ensure items is an array
            'items.*.title' => 'required|max:255', // Validate title in each item
            'items.*.ratio' => 'required|numeric|max:100', // Validate title in each item
            'items.*.staff_evaluation' => 'required|numeric|max:100', // Validate title in each item
            'items.*.assessment_manager' => 'required|numeric|max:100', // Validate title in each item
            'items.*.target' => 'nullable|numeric|max:100', // Validate title in each item
            'items.*.manager_note' => 'nullable|max:1000', // Validate title in each item
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id' => Lang::get('messages.user_id'),
            'name' => Lang::get('messages.kpi-name'),
            'start_at' => Lang::get('messages.start_at'),
            'end_at' => Lang::get('messages.end_at'),
            'description' => Lang::get('messages.description'),
            'note' => Lang::get('messages.note'),
            'items' => Lang::get('messages.target'),
            'items.*.title' => Lang::get('messages.kpi_detail-title'),
            'items.*.ratio' => Lang::get('messages.kpi_detail-ratio'),
            'items.*.staff_evaluation' => Lang::get('messages.kpi_detail-staff_evaluation'),
            'items.*.assessment_manager' => Lang::get('messages.kpi_detail-assessment_manager'),
            'items.*.manager_note' => Lang::get('messages.kpi_detail-manager_note'),
        ];
    }

    public function filters()
    {
        return [];
    }
}
