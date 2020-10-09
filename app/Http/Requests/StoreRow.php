<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRow extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_time' => 'required|string|date',
            'boat_name' => 'required|max:8',
            'on_the_water' => 'required|date_format:H:i',
            'off_the_water' => 'required|date_format:H:i',
            'lower_limit_area' => 'required|string|max:6',
            'upper_limit_area' => 'required|string|max:6',
            'others' => 'nullable|max:24',
        ];
    }
}
