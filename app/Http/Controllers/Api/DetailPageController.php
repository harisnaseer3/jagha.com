<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PropertyController;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPageController extends Controller
{
    function getSimilarProperties(Request $request)
    {
        $property = Property::where('id', '=', $request->input('property'))->first();
        $similar_properties = (new PropertyController)->listingFrontend()
            ->where([
                ['properties.id', '<>', $property->id],
                ['properties.city_id', '=', $property->city_id],
                ['properties.type', '=', $property->type],
                ['properties.sub_type', '=', $property->sub_type],
                ['properties.purpose', '=', $property->purpose],
            ])->limit(10)->get();
        if ($similar_properties->isEmpty()) {
            return $data = 'not available';
        } else {
            $data['view'] = View('website.components.similar_properties',
                ['similar_properties' => $similar_properties])->render();
            return $data;
        }

    }

    function getPropertyFavoriteUser(Request $request)
    {
        if ($request->ajax()) {
            $property_id = $request->input('property');
            $result = DB::table('favorites')->select('user_id')->where('property_id', '=', $property_id)->get()->pluck('user_id');
            if(!$result->isEmpty())
                return response()->json(['data' => $result[0], 'status' => 200]);
            else
                return response()->json(['data' => 'not available', 'status' => 200]);

        }
    }

}
