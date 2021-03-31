<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountTableController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertySearchController;


class IndexPageController extends Controller
{
    public function getPopularPlaces()
    {
        $popular_locations = (new CountTableController())->popularLocations();
        $data['view'] = View('website.components.popular_places',
            [
                'popular_cities_homes_on_sale' => $popular_locations['popular_cities_homes_on_sale'],
                'popular_cities_plots_on_sale' => $popular_locations['popular_cities_plots_on_sale'],
                'city_wise_homes_data' => [
                    'karachi' => $popular_locations['city_wise_homes_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_homes_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_homes_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_homes_data']['rawalpindi/Islamabad']
                ],
                'city_wise_plots_data' => [
                    'karachi' => $popular_locations['city_wise_plots_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_plots_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_plots_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_plots_data']['rawalpindi/Islamabad']
                ],
                'city_wise_commercial_data' => [
                    'karachi' => $popular_locations['city_wise_commercial_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_commercial_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_commercial_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_commercial_data']['rawalpindi/Islamabad']
                ],
                'popular_cities_commercial_on_sale' => $popular_locations['popular_cities_commercial_on_sale'],
                'popular_cities_property_on_rent' => $popular_locations['popular_cities_property_on_rent'],
            ])->render();

        return $data;

    }

    function getFeaturedProperties()
    {
        $featured_properties = (new PropertySearchController)->listingfrontend()
            ->where('properties.golden_listing', '=', 1)
            ->orderBy('properties.golden_listing', 'DESC')
            ->orderBy('properties.activated_at', 'DESC')
            ->get();

        $data['view'] = View('website.components.feature_properties',
            ['featured_properties' => $featured_properties])->render();

        return $data;
    }

    function getAboutPakistanProperties()
    {
        $featured_properties = (new PropertySearchController)->listingfrontend()
            ->where('properties.golden_listing', '=', 1)
            ->orderBy('properties.golden_listing', 'DESC')
            ->orderBy('properties.activated_at', 'DESC')
            ->get();

        $data['view'] = View('website.components.about_pakistan_properties',
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
