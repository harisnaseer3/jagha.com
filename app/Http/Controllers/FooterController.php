<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Property;

class FooterController extends Controller
{
    public function footerContent()
    {
        $recent_properties = (new Property)
            ->select('properties.id', 'properties.title', 'properties.reference', 'properties.price', 'properties.created_at',
                'properties.updated_at', 'locations.name AS location', 'cities.name AS city')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.status', '=', 'active')
            ->whereNull('properties.deleted_at')
            ->orderBy('created_at', 'DESC')
            ->limit(7)
            ->get();

        $footer_agencies = (new Agency)->select('agencies.title', 'agencies.id', 'agencies.featured_listing', 'agencies.description', 'agencies..key_listing', 'agencies.featured_listing', 'agencies.status',
            'agency_cities.city_id','cities.name AS city', 'agencies.phone', 'agencies.cell', 'agencies.ceo_name AS agent', 'agencies.logo')
            ->where('agencies.status', '=', 'verified')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')
            ->where('featured_listing', '=', '1')
            ->orderBy('agencies.created_at', 'DESC')
            ->limit(7)
            ->get();
        return [$recent_properties, $footer_agencies];
    }
}
