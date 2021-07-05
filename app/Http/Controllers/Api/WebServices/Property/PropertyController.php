<?php

namespace App\Http\Controllers\Api\WebServices\Property;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Property as PropertyResource;
use App\Http\Resources\PropertyListing as PropertyListingResource;

class PropertyController extends Controller
{
    // Display detailed page of property
    public function show(Request $request)
    {

        $property = Property::where('id', $request->property)->first();
        if ($property) {

//            $views = $property->views;
//            $property->views = $views + 1;
//            $property->save();

            $is_favorite = false;

            if (Auth::guard('api')->check()) {
                $is_favorite = DB::table('favorites')->select('id')
                    ->where([
                        ['user_id', '=', Auth::guard('api')->user()->getAuthIdentifier()],
                        ['property_id', '=', $property->id],
                    ])->exists();
            }
            $property->city = $property->city->name;
            $property->location = $property->location->name;

            $similar_properties = (new PropertySearchController())->listingFrontend()
                ->where([
                    ['properties.id', '<>', $property->id],
                    ['properties.city_id', $property->city_id],
                    ['properties.type', $property->type],
                    ['properties.sub_type', $property->sub_type],
                    ['properties.purpose', $property->purpose],
                ]);

            $sort_area = 'higher_area';
            $sort = 'newest';

            $similar_properties = (new PropertySearchController())->sortPropertyListing($sort, $sort_area, $similar_properties);

            $similar_properties = $similar_properties->limit(10)->get();

            if ($similar_properties->count() > 0) {
                $similar_properties = (new PropertyListingResource)->myToArray($similar_properties);
            } else
                $similar_properties = [];


            $data = (object)[
                'property' => new PropertyResource($property),
                'similar_properties' => $similar_properties
            ];

            return (new \App\Http\JsonResponse)->success("Property Details", $data);
        } else
            return (new \App\Http\JsonResponse)->resourceNotFound();


    }

}
