<?php

namespace App\Http\Controllers\Api;

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

        $data['view'] = View('website.components.similar_properties',
            ['similar_properties' => $featured_properties])->render();

        return $data;
    }
}
