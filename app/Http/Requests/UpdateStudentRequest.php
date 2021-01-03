<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'givenName' => 'string|max:255',
            'surName' => 'string|max:255',
            'initials' => 'string|max:255',
            'displayName' => 'string|max:255',
            'description' => 'string|max:255',
        ];
    }
}
