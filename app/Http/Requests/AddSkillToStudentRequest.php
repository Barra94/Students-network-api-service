<?php
/**
 * Created by PhpStorm.
 * User: barra
 * Date: 11/9/2020
 * Time: 12:00 AM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddSkillToStudentRequest extends FormRequest
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
            'skill' => 'required|string|max:255',
            'type' => 'required|string|max:255|in:soft skill,hard skill',
            'level' => 'required|integer|between:1,5',
        ];
    }
}