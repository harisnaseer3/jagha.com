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
            //recently_viewed_properties
            $user_id = auth::guard('api')->user()->id;
            $properties = RecentlyViewedProperty::select('property_id')->where('user_id', $user_id)->get()->pluck('property_id')->toArray();

            if (count($properties) > 0) {
                return (new \App\Http\JsonResponse)->success("User Recently Viewed Properties", $properties);
            } else
                return (new \App\Http\JsonResponse)->successNoContent();
        }
        return (new \App\Http\JsonResponse)->successNoContent();

    }
}


