<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class InvestorRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
//            'cnic' => 'bail|required|string|max:15|unique:users,cnic',
//            'city' => 'bail|required|exists:cities,name',
            'cnic_first' => 'required|digits:5',
            'cnic_middle' => 'required|digits:7',
            'cnic_last' => 'required|digits:1',
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
