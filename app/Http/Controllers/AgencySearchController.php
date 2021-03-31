<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class AgencySearchController extends Controller
{
    public function searchPartner(Request $request)
    {
        if ($request->has('city') && $request->input('city') != '') {
            $city = City::select('id', 'name')->where('name', '=', $request->input('city'))->first();
            if ($request->input('title') !== null && $city) {
                $property_types = (new PropertyType)->all();
                (new MetaTagController())->addMetaTagsOnPartnersListing();

                $footer_content = (new FooterController)->footerContent();

                $limit = '';
                $sort = '';
                if (request()->input('limit') !== null)
                    $limit = request()->input('limit');
                else
                    $limit = '15';
                if (request()->input('sort') !== null)
                    $sort = request()->input('sort');
                else
                    $sort = 'newest';

                $agencies = (new AgencyController)->_listingFrontend()
                    ->where('agencies.title', 'LIKE', '%' . request()->input('title') . '%')
                    ->where('agencies.city_id', '=', $city->id);

                if ($request->has('page') && $request->input('page') > ceil($agencies->count() / $limit)) {
                    $lastPage = ceil((int)$agencies->count() / $limit);
                    $request->merge(['page' => (int)$lastPage]);
                }
                $agencies = $agencies
                    ->orderBy('agencies.created_at', $sort === 'newest' ? 'DESC' : 'ASC');

                $data = [
                    'agency_city' => $city->name,
                    'agency_title' => $request->input('title'),
                    'property_types' => $property_types,
                    'agencies' => $agencies->paginate($limit),
                    'recent_properties' => $footer_content[0],
                    'footer_agencies' => $footer_content[1],
                ];
                return view('website.pages.agency_listing', $data);
            } elseif ($request->input('title') == null && $city) {
                return $this->getAgencies($city->name, $request);
            }
        } else if ($request->has('city') && $request->input('city') == '')
            return back();
        else
            return back();

    }

    public function getAgencies(string $city, Request $request)
    {

        $city_name = ucwords(str_replace('-', ' ', $city));
        $city_id = City::select('id')->where('name', '=', $city_name)->first();

        $limit = '';
        $sort = '';
        if (request()->has('limit'))
            $limit = request()->input('limit');
        else
            $limit = '15';
        if (request()->has('sort'))
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        $agencies = (new agencyController)->_listingFrontend()
            ->where('agency_cities.city_id', '=', $city_id->id);

        if ($request->has('page') && $request->input('page') > ceil($agencies->count() / $limit)) {
            $lastPage = ceil((int)$agencies->count() / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }
        $agencies = $agencies->groupBy('agencies.title', 'agencies.id', 'agencies.featured_listing', 'agency_cities.city_id', 'property_count_by_agencies.property_count')
            ->orderBy('agencies.created_at', $sort === 'newest' ? 'DESC' : 'ASC');

        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTagsOnPartnersListing();

        $footer_content = (new FooterController)->footerContent();
        $data = [
            'agency_city' => $city,
            'agency_title' => $request->input('title'),
            'property_types' => $property_types,
            'agencies' => $agencies->paginate($limit),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];
        return view('website.pages.agency_listing', $data);
    }

//    public function getAdminAgencyByName(){
//
//    }
}
