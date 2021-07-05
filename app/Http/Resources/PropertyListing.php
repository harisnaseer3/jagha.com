<?php

namespace App\Http\Resources;

class PropertyListing
{
    public function myToArray($results)
    {
        $clean_results = array();

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
                'land_area' => $item->land_area,
                'area_unit' => $item->area_unit,
                'bedrooms' => $item->bedrooms,
                'bathrooms' => $item->bathrooms,

                'golden_listing' => $item->golden_listing,
                'platinum_listing' => $item->platinum_listing,
                'contact_person' => $item->contact_person,
                'phone' => $item->phone,
                'cell' => $item->cell,
                'email' => $item->email,
                'views' => $item->views,
                'favorites' => $item->favorites,
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
}
