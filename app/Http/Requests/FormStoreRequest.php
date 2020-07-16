<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'currency' => 'required',
            'price' => 'required',
            'price_unit' => 'required',
            'area' => 'required',
            'area_unit' => 'required',
            'image_map_url' => 'required|url',
            'build_year' => ['required', 'regex:/^\d{4}+$/'],
            'description' => 'required|string',
            'bed' => 'required',
            'bath' => 'required',
            'kitchen' => 'required',
            'store_room' => 'required',
            'lounge_or_dinning_room' => 'required',
            'drawing_room' => 'required',
            'total_floors' => 'required',
            'current_floor' => 'required',
            'neighbourhood_distance_unit' => 'required',
            'distance_from_hospital' => 'required',
            'distance_from_airport' => 'required',
            'distance_from_school' => 'required',
            'distance_from_restaurants' => 'required',
            'distance_from_shopping_mall' => 'required',
            'is_active' => 'required|boolean',
        ];
    }

//    public function messages()
//    {
//        return [
//            'title.required' => 'Title is required!',
//            'title.max:255' => 'Title is too long!',
//        ];
//    }
}
