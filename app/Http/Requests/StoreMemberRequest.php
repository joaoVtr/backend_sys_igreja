<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
                'unique:members,cpf'
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
