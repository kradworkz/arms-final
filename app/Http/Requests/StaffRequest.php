<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|string|max:150|unique:users,email,'.$this->id,
            'member_id' => 'sometimes|required|integer',
            'municipality_id' => 'sometimes|required|integer',
            'img' => 'nullable|image64:jpeg,jpg,png',
        ];
    }
}
