<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authorize()
    {
        $this->getValidatorInstance()->validate();

        return $this->user()->email == $this->email && Hash::check($this->current_password, $this->user()->password);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'current_password' => 'required|string',
            'new_password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:new_password',
        ];
    }
}