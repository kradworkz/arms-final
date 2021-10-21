<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
        $member_id = \Auth::user()->member->mm->id;
        return [
            'name' => 'required|string|max:150|unique:locations,name,'.$this->id.',id,mm_id,'.$member_id,
            'address' => 'required|string|max:100',
            'contact_no' => 'required',
            'coordinates' => 'required'
        ];
    }
}
