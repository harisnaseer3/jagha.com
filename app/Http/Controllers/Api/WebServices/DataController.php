<?php

namespace App\Http\Controllers\Api\WebServices;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\City;
use App\Http\Resources\CityListing as CityListingResource;
use App\Http\Resources\LocationListing as LocationListingResource;
use App\Models\Dashboard\Location;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function cities()
    {
        $data = (new CityListingResource)->myToArray(City::all()->where('is_active', '1'));
        return (new \App\Http\JsonResponse)->success("Cities List", $data);
    }

    public function locations(Request $request)
    {
        if ($c = $request->city) {
            $locations = [];
            $city = City::find($c);

            if ($city) {
                $locations = (new \App\Models\Dashboard\Location)->where('city_id', $city->id)->get();

                if (!$locations->isEmpty()) {
                    $locations = (new LocationListingResource)->myToArray($locations);
                    return (new \App\Http\JsonResponse)->success("Locations List", $locations);
                } else
                    return (new \App\Http\JsonResponse)->successNoContent();

            } else
                return (new \App\Http\JsonResponse)->resourceNotFound();

        }
        return (new \App\Http\JsonResponse)->unprocessable();
    }
}
