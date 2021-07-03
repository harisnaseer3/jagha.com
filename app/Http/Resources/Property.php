<?php

namespace App\Http\Resources;

use App\Models\Agency;
use Illuminate\Http\Resources\Json\JsonResource;

class Property extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $agency = [];
        if ($this->agency_id != null) {
            $agency_data = Agency::getAgencyById($this->agency_id);

            $agency = [
                'title' => $agency_data->title,
                'description' => $this->user_id !== 1 ? $agency_data->description : '',
                'phone' => $agency_data->phone,
                'cell' => $agency_data->cell,
                'address' => $agency_data->address,
                'email' => $agency_data->email,
                'logo' => $this->user_id !== 1 ? $agency_data->logo : '',
                'ceo' => $agency_data->ceo_name,
                'featured_listing' => $agency_data->featured_listing,
                'key_listing' => $agency_data->key_listing,
                'contact_person' => \App\Models\Dashboard\User::getUserName($agency_data->user_id)

            ];
        }
        $images = [];
        if (!$this->images->isEmpty() && $this->user_id !== 1) {
            foreach ($this->images as $img) {
                $images[] = strpos($img->name, '.webp') !== false ? $img->name : $img->name . '.webp';

            }
        }

        return [
            'city' => $this->city,
            'location' => $this->location,
            'title' => $this->title,
            'description' => $this->user_id !== 1 ? $this->description : '',
            'images' => $images,
            'type' => $this->type,
            'sub_type' => $this->sub_type,
            'purpose' => $this->purpose,
            'sub_purpose' => $this->sub_purpose,
            'price' => $this->price,
            'land_area' => $this->land_area,
            'area_unit' => $this->area_unit,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'features' => $this->features,
            'golden_listing' => $this->golden_listing,
            'platinum_listing' => $this->platinum_listing,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'cell' => $this->cell,
            'email' => $this->email,
            'views' => $this->views,
            'favorites' => $this->favorites,
            'activated_at' => $this->activated_at,
            'agency' => $agency
        ];

    }
}
