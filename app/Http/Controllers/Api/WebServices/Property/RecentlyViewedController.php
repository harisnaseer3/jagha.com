<?php

namespace App\Http\Controllers\Api\WebServices\Property;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyListing as PropertyListingResource;
use App\Models\RecentlyViewedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecentlyViewedController extends Controller
{
    public function store($user_id, $property_id)
    {
//        $recently = new RecentlyViewedProperty;
//        $recently->user_id = $user_id;
//        $recently->property_id = $property_id;
//        $recently->save();
        $recently = RecentlyViewedProperty::updateOrCreate(
            ['user_id' => $user_id, 'property_id' => $property_id],
            ['user_id' => $user_id, 'property_id' => $property_id]
        );

    }

    public function show()
    {
        if (auth::guard('api')->check()) {

            $user_id = auth::guard('api')->user()->id;
            $property_list = RecentlyViewedProperty::select('property_id')->where('user_id', $user_id)->get()->pluck('property_id')->toArray();


            if (count($property_list) > 0) {
                $properties = (new PropertySearchController)->listingFrontend()
                    ->whereIn('properties.id', $property_list);

                $sort_area = 'higher_area';
                $sort = 'newest';

                $properties = (new PropertySearchController())->sortPropertyListing($sort, $sort_area, $properties)->get();


                if ($properties->count() > 0) {
                    $properties = (new PropertyListingResource)->myToArray($properties);
                    return (new \App\Http\JsonResponse)->success("User Favourites Listing", $properties);
                } else
                    return (new \App\Http\JsonResponse)->successNoContent();
            }
            return (new \App\Http\JsonResponse)->successNoContent();

        }

//         return (new \App\Http\JsonResponse)->unauthorized();

    }
}


