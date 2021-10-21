<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'station' => 'sometimes|required|string|max:150|unique:devices,station,'.$this->id,
            'data_logger' => 'sometimes|required|string|max:30',
            'coordinates' => 'sometimes|required|string|max:100',
            'remarks' => 'sometimes|required|string',
            'status_id' => 'sometimes|required|integer',
            'municipality_id' => 'sometimes|required|integer',
            'type_id' => 'sometimes|required|integer'
        ];
    }

    public function messages()
    {
        $message =  [
            'station.required' => '* required',
            'datalogger.required' => '* required',
            'coordinates.required' => '* required',
            'remarks.required' => '* required',
            'status.required' => '* required',
            'municipality.required' => '* required',
            'type.required' => '* required',
        ];

        return $message;
    }
}
