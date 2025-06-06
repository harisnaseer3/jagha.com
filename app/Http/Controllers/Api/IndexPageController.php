<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountTableController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertySearchController;
use App\Models\Agency;


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
//function to fetch properties of platinum package
    function getFeaturedProperties()
    {
        $featured_properties = (new PropertySearchController)->listingfrontend()
//            ->where('properties.platinum_listing', '=', 1)
                ->where('properties.city_id', 4)
//            ->whereIn('properties.id', [283694, 283695, 283696, 283697, 283698, 283699, 283616, 283617, 283628, 283620, 283621, 283622])
            ->orderBy('properties.platinum_listing', 'DESC')
            ->orderBy('properties.activated_at', 'DESC')
            ->get();

        $data['view'] = View('website.components.feature_properties',
            ['featured_properties' => $featured_properties])->render();

        return $data;
    }

    function getProperties()
    {
        $featured_properties = (new PropertySearchController)->listingfrontend()
            ->where('properties.platinum_listing', '=', 1)
            ->orderBy('properties.platinum_listing', 'DESC')
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

    public function aboutUs()
    {
        $testimonials = $this->showTestimonials();
        $featured_agencies = (new AgencyController())->FeaturedAgencies();
        return view('website.pages.about_us', compact('testimonials', 'featured_agencies'));
    }

    public function showTestimonials()
    {
        return Agency::where('featured_listing', 1)
            ->whereNotNull('ceo_message')
            ->where('is_active', 1)
            ->select('ceo_message as review', 'ceo_name as name', 'title as company')
            ->latest('created_at')
            ->take(5)
            ->get();
    }

}
