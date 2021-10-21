<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackerRequest extends FormRequest
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
            'trackercode' => 'required|string|unique:asset_lists,tracker_code,'.$this->id,
            'assetcode' => 'required|string|unique:asset_lists,asset_code,'.$this->id,
        ];
    }
}
