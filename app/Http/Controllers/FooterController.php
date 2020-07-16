<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Property;

class FooterController extends Controller
{
    public function footerContent()
    {
        $recent_properties = (new Property)
            ->select('properties.id', 'properties.title', 'properties.reference', 'properties.price', 'properties.created_at', 'properties.updated_at', 'locations.name AS location', 'cities.name AS city')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.status', '=', 'active')
            ->whereNull('properties.deleted_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        $footer_agencies = (new Agency)->select('title', 'city', 'cell', 'ceo_name')->where('status', '=', 'verified')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();
        return [$recent_properties, $footer_agencies];
    }
}
