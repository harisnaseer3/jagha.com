<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Property;

class FooterController extends Controller
{
    public function footerContent()
    {
        $recent_properties = (new Property)
            ->select('properties.id', 'properties.title', 'properties.reference', 'properties.price', 'locations.name AS location', 'cities.name AS city')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.status', '=', 'active')
            ->orderBy('properties.id', 'DESC')
            ->limit(7)
            ->get();

        $footer_agencies = (new Agency)->select('agencies.title', 'agencies.id',
            'agency_cities.city_id', 'cities.name AS city', 'agencies.phone', 'agencies.cell', 'agencies.ceo_name AS agent')
            ->where('agencies.status', '=', 'verified')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')
            ->where('featured_listing', '=', '1')
            ->orderBy('agencies.updated_at', 'DESC')
            ->limit(7)
            ->get();
        return [$recent_properties, $footer_agencies];
    }
}
