<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'church_id' => [
                'exists:churches,id',
                'required'
            ],
            'name' => [
                'required'
            ],
            'cpf' => [
                'required',
                Rule::unique('members', 'cpf')->ignore(Request::segment(3), 'id')
            ],
            'birthday' => [
                'date',
                'required'
            ],
            'email' => [
                'required',
                'email'
            ],
            'cell_number' => [
                'required',
            ],
            'street_name' => [
                'required',
            ],
            'city' => [
                'required'
            ],
            'state' => [
                'required',
                'min:2',
                'max:2'
            ]
        ];
    }
}
