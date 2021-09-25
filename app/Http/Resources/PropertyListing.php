<?php

namespace App\Http\Resources;

use App\Models\Agency;

class PropertyListing
{
    public function myToArray($results, $area_unit = null, $area = null)
    {
        $clean_results = array();

        if ($area !== null)
            $area = explode('properties.', $area)[1];


        foreach ($results as $item) {
            $image = '';
            if ($item->image !== null) {
                $image = strpos($item->image, '.webp') !== false ? $item->image : $item->image . '.webp';
            }


            array_push($clean_results, [
                'id' => $item->id,
                'city' => $item->city,
                'location' => $item->location,
                'title' => $item->title,
                'description' => $item->user_id !== 1 ? $item->description : '',
                'image' => $item->user_id !== 1 ? $image : '',
                'type' => $item->type,
                'sub_type' => $item->sub_type,
                'purpose' => $item->purpose,
                'sub_purpose' => $item->sub_purpose,
                'price' => $item->price,
                'land_area' => $area == null ? $item->land_area : $item->$area,
                'area_unit' => $area_unit != null ? $area_unit : $item->area_unit,
                'bedrooms' => $item->bedrooms,
                'bathrooms' => $item->bathrooms,

                'golden_listing' => $item->golden_listing == 1,
                'platinum_listing' => $item->platinum_listing == 1,
                'contact_person' => $item->contact_person,
                'phone' => $item->phone,
                'cell' => $item->cell,
                'email' => $item->email,
                'views' => $item->views,
                'favorites' => $item->favorites,
                'user_favourite' => $item->user_favorite == null ? 0 : 1,
                'activated_at' => $item->activated_at,
                'agency' => $item->agency,
                'logo' => $item->user_id !== 1 ? $item->logo : '',
                'agency_phone' => $item->agency_phone,
                'agency_cell' => $item->agency_cell,
                'ceo' => $item->agent,
                'agency_description' => $item->user_id !== 1 ? $item->agency_description : '',
            ]);
        }

        return $clean_results;
    }

    public function CleanEditPropertyData($property)
    {
        $images = [];
        if (!$property->images->isEmpty()) {
            foreach ($property->images as $img) {
                $images[] = strpos($img->name, '.webp') !== false ? $img->name : $img->name . '.webp';
            }
        }

        return [
            'city' => $property->city,
            'location' => $property->location->name,
            'title' => $property->title,
            'description' => $property->description,
            'type' => $property->type,
            'sub_type' => $property->sub_type,
            'purpose' => $property->purpose,

            'price' => $property->price,
            'land_area' => $property->land_area,
            'area_unit' => $property->area_unit,
            'bedrooms' => $property->bedrooms,
            'bathrooms' => $property->bathrooms,


            'contact_person' => $property->contact_person,
            'phone' => $property->phone,
            'cell' => $property->cell,
            'email' => $property->email,
            'agency' => $property->agency_id
        ];
    }

    public function dataCleaning($properties, $area_unit = null, $area = null)
    {
        $clean_results = array();


        foreach ($properties as $index => $item) {

            $image = '';
            if (!$item->images->isEmpty()) {
                $image = strpos($item->images[0]->name, '.webp') !== false ? $item->images[0]->name : $item->images[0]->name . '.webp';
            }

            array_push($clean_results, [
                'id' => $item->id,
                'city' => $item->city->name,
                'location' => $item->location->name,
                'title' => $item->title,
                'description' => $item->user_id !== 1 ? $item->description : '',
                'image' => $item->user_id !== 1 ? $image : '',

                'type' => $item->type,
                'sub_type' => $item->sub_type,
                'purpose' => $item->purpose,
//                'sub_purpose' => $item->sub_purpose,
                'price' => $item->price,
                'land_area' => $area == null ? $item->land_area : $item->$area,
                'area_unit' => $area_unit != null ? $area_unit : $item->area_unit,
                'bedrooms' => $item->bedrooms,
                'bathrooms' => $item->bathrooms,

                'golden_listing' => $item->golden_listing,
                'platinum_listing' => $item->platinum_listing,
                'contact_person' => $item->contact_person,
                'phone' => $item->phone,
                'cell' => $item->cell,
                'email' => $item->email,
                'views' => $item->views,

                'favorites_count' => $item->favorites,
                'user_favourite' => isset($item->userFavorites[0]->user_id) ? 1 : 0,
                'activated_at' => $item->activated_at,
                'agency' => isset($item->agency) ? $item->agency->agency_title : '',
                'logo' => isset($item->agency) && $item->user_id !== 1 ? $item->agency->logo : '',
                'agency_phone' => isset($item->agency) ? $item->agency->phone : '',
                'agency_cell' => isset($item->agency) ? $item->agency->cell : '',
                'ceo' => isset($item->agency) ? $item->ceo_name : '',
                'agency_description' => isset($item->agency) && $item->user_id !== 1 ? $item->agency->description : '',
            ]);
        }
        return $clean_results;


    }
}

