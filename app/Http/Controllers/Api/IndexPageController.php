<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PropertyController;


class IndexPageController extends Controller
{
    function getFeaturedProperties()
    {
        $featured_properties = (new PropertyController)->listingfrontend()
            ->where('properties.platinum_listing', '=', 1)
            ->orderBy('views', 'DESC')
            ->limit(10)
            ->get();

        $data['view'] = View('website.components.feature_properties',
            ['featured_properties' => $featured_properties])->render();

        return $data;
    }

    function getKeyAgencies()
    {
        $key_agencies = (new AgencyController)->keyAgencies();
        $data['view'] = View('website.components.key_agencies',
            ['key_agencies' => $key_agencies])->render();
        return $data;
    }

    function getFeaturedAgencies()
    {
        $featured_agencies = (new AgencyController())->FeaturedAgencies();
        $data['view'] = View('website.components.featured_agencies',
            ['featured_agencies' => $featured_agencies])->render();
        return $data;
    }
}
