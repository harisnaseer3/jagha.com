<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertySearchController;
use App\Http\Requests\Agency\GetAgencyPropertiesRequest;
use App\Models\Agency;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPageController extends BaseController
{
    function getSimilarProperties(Request $request)
    {
        if ($request->ajax()) {
            $property = Property::where('id', '=', $request->input('property'))->first();
            $similar_properties = (new PropertySearchController)->listingFrontend()
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
    }

    function getAgencyProperties(Request $request)
    {
        if ($request->ajax()) {
            $agency_properties = (new PropertySearchController)->listingFrontend()
                ->where([
                    ['properties.id', '<>', $request->property],
                    ['properties.agency_id', '=', $request->agency],
//                    ['properties.type', '=', $property->type],
//                    ['properties.sub_type', '=', $property->sub_type],
//                    ['properties.purpose', '=', $property->purpose],
                ])
//                ->limit(10)
                ->get();
            if ($agency_properties->isEmpty()) {
                return $data = 'not available';
            } else {
                $data['view'] = View('website.components.agency_properties',
                    ['agency_properties' => $agency_properties])->render();
                return $data;
            }
        }
    }

    public function agencyProperties(GetAgencyPropertiesRequest $request) // get agency properties api
    {
        try {
            $excludePropertyId = $request->property_id;

            $query = (new PropertySearchController)->listingFrontend()
                ->where('properties.agency_id', $request->agency_id);

            if ($excludePropertyId) {
                $query->where('properties.id', '<>', $excludePropertyId);
            }

            $agency_properties = $query->get();

            if ($agency_properties->isEmpty()) {
                return $this->sendResponse([], 'No properties found for this agency.');
            }

            return $this->sendResponse($agency_properties, 'Agency properties fetched successfully.');


        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch agency properties.', $e->getMessage(), 500);
        }
    }

    public function cityProperties(Request $request)
    {
        try{
            $perPage = $request->per_page ?? 10;

            $query = (new PropertySearchController)->listingFrontend()
            ->where('properties.city_id', $request->city_id)->paginate($perPage);

            if ($query->isEmpty()) {
                return $this->sendResponse([], 'No properties found for this city.');
            }
            return $this->sendResponse($query, 'City properties fetched successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch city properties.', $e->getMessage(), 500);
        }
    }


    function getPropertyFavoriteUser(Request $request)
    {
        if ($request->ajax()) {
            $property_id = $request->input('property');
            $result = DB::table('favorites')->select('user_id')->where('property_id', '=', $property_id)->get()->pluck('user_id');
            if (!$result->isEmpty())
                return response()->json(['data' => $result[0], 'status' => 200]);
            else
                return response()->json(['data' => 'not available', 'status' => 200]);

        }
    }

}
