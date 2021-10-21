<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropdownRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:100|unique:dropdowns,name,NULL,'.$this->id.',type,'.$this->type,
            'type' => 'required|string|max:30',
        ];

        
        if($this->selected == 'Category'){
            $rules = array_merge($rules, ['color' => 'required|unique:dropdowns,color,NULL,'.$this->id.',classification,'.$this->selected]);
        }else if($this->selected == 'Asset'){
            $rules = array_merge($rules, ['color' => 'required|unique:dropdowns,color,NULL,'.$this->id.',type,'.$this->type]);
        }else{
            $rules = array_merge($rules, ['color' => 'required']);
        }
        
        
        return $rules;
    }
}
