<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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

        $rules = [
            'name' => 'required|string|unique:assets,name,NULL,'.$this->id.',mm_id,'.$member_id,
            'category' => 'required',
            'avatar' => 'nullable|image64:jpeg,jpg',
            'brand' => 'nullable|string|max:150',
            'serial_no' => 'nullable|string|max:150',
            'model' => 'nullable|string|max:150',
            'desc' => 'nullable|string',
        ];

        foreach($this->lists as $key => $staff) {
            if ( array_key_exists('id', $staff) && $staff['id'] ) { // if have an id, means an update, so add the id to ignore
                $rules = array_merge($rules, ['lists.'.$key.'.name' => 'required|unique:subspecializations,name,'.$staff['id']]);
            } else {  // just check if the email it's not unique
                $rules = array_merge($rules, ['lists.'.$key.'.quantity' => 'required']);
                $rules = array_merge($rules, ['lists.'.$key.'.location' => 'required']);
            }
        }

        return $rules;
    }

    public function messages()
    {
        $message =  [
            'name.required' => '* required',
            'category.required' => '* required',
        ];

        foreach($this->lists as $key => $staff) {
            $message = array_merge($message, ['lists.'.$key.'.quantity.required' => '(* required)']);
            $message = array_merge($message, ['lists.'.$key.'.location.required' => '(* required)']);
        }

        return $message;
    }
}
