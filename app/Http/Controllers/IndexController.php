<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HitRecord\HitController;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\FacebookPost;

class IndexController extends Controller
{
    //    display data on index page
    public function index()
    {
//        try {
//            HitController::record();
//        } catch (\Exception $e) {
//            dd($e->getMessage());
//        }
        //$property  = Property::where('id',278917)->first();
        //$this->dispatch(new FacebookPost($property));
        (new MetaTagController())->addMetaTags();

//        if (!(new Visit)->hit()) {
//            return view('website.errors.404');
//        }

        (new Visit)->hit();

        $property_types = (new PropertyType)->all();

        // property count table
        $total_count = DB::table('total_property_count')->select('property_count', 'sale_property_count', 'rent_property_count', 'agency_count', 'city_count')->first();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'total_count' => $total_count,
            'cities_count' => (new CountTableController())->getCitiesCount(),
            'property_types' => $property_types,
            'localBusiness' => (new MetaTagController())->addScriptJsonldTag(),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];

        return view('website.index', $data);
    }

    public function updateCount()
    {
        try {
            $totalCount = Property::count();
            $rentPropertyCount = Property::where('purpose', 'Rent')->count();
            $salePropertyCount = Property::where('purpose', 'Sale')->count();
            $agencyPropertyCount = Agency::where('is_active', '1')->count();
            $cityCount = City::count();

            DB::table('total_property_count')->update([
                'property_count' => $totalCount,
                'rent_property_count' => $rentPropertyCount,
                'sale_property_count' => $salePropertyCount,
                'agency_count' => $agencyPropertyCount,
                'city_count' => $cityCount,
            ]);

            return response()->json([
                'message' => 'Counts updated successfully',
                'data' => [
                    'property_count' => $totalCount,
                    'rent_property_count' => $rentPropertyCount,
                    'sale_property_count' => $salePropertyCount,
                    'agency_count' => $agencyPropertyCount,
                    'city_count' => $cityCount,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update counts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
