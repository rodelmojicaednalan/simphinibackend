<?php

namespace App\Http\Requests\Picklists;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Support\Facades\Validator;

class CountryRequest extends FormRequest
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
        // return [
        //     'name' => [
        //                 'required', 
        //                 'min:3', 
        //                 'max:255'
        //             ],
        //     'code' => [
        //                 'required', 
        //                 'min:2', 
        //                 'max:3'
        //             ],
        //     'nationality' => [
        //                         'required', 
        //                         'min:3', 
        //                         'max:255'
        //                     ]
        // ];
        return [
            'name' => 'required|min:3|max:255',
            'code' => 'required|min:2|max:3',
            'nationality' => 'required|min:3|max:255'
        ];
        // , 
        // [
        //     'name.required' => 'Country name is a required field.',
        //     'name.min' => 'Country name must be more than 3 characters.',
        //     'name.max' => 'Country name must be less than 255 characters.',
        //     'code.required' => 'Country code is a required field.',
        //     'code.min' => 'Country code must be more than 2 characters.',
        //     'code.max' => 'Country code must be less than 3 characters.',
        //     'nationality.required' => 'Nationality is a required field.',
        //     'nationality.min' => 'Nationality must be more than 2 characters.',
        //     'nationality.max' => 'Nationality must be less than 3 characters.',
        // ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Country name is a required field.',
            'name.min' => 'Country name must be more than 3 characters.',
            'name.max' => 'Country name must be less than 255 characters.',
            'code.required' => 'Country code is a required field.',
            'code.min' => 'Country code must be more than 2 characters.',
            'code.max' => 'Country code must be less than 3 characters.',
            'nationality.required' => 'Nationality is a required field.',
            'nationality.min' => 'Nationality must be more than 2 characters.',
            'nationality.max' => 'Nationality must be less than 3 characters.',
        ];
    }
}