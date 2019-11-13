<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SaveThingspeakDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'group'   => 'required',
            'channel' => [
                'required', 'numeric',
                Rule::unique('thingspeaks')->ignore($this->input('id')),
            ],
            'party'   => 'required_if:group,Independent',
            'maker'   => 'required',
            'fields'  => 'required|array',
            'active'  => 'boolean',
        ];
    }
}
