<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PropertyController;
use App\Models\Property;
use Illuminate\Http\Request;

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
            ])->limit(10)->get();
        $data['view'] = View('website.components.similar_properties',
            ['similar_properties' => $similar_properties])->render();

        return $data;
    }


}
