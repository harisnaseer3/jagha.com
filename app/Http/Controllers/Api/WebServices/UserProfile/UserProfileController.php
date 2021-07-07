<?php

namespace App\Http\Controllers\Api\WebServices\UserProfile;

use App\Http\Controllers\Api\WebServices\Property\PropertySearchController;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyListing as PropertyListingResource;
use App\Http\Resources\User as UserResource;
use App\Models\Account;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function updateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'area_unit' => ['required', Rule::in(['Square Feet', 'Square Yards', 'Square Meters', 'Marla', 'Kanal'])],
            'language' => 'required',
            'number' => 'required'
        ]);
        if ($validator->fails()) {
            return (new \App\Http\JsonResponse)->unprocessable($validator->errors()->all());
        }

        (new Account)->updateOrCreate(['user_id' => Auth::guard('api')->user()->getAuthIdentifier()], [
            'default_area_unit' => $request->area_unit,
            'default_language' => $request->language,
        ]);

        auth('api')->user()->update([
            'name' => $request->name,
            'cell' => $request->number
        ]);


        if ($validator->fails()) {
            return (new \App\Http\JsonResponse)->unprocessable($validator->errors()->all());
        }

        auth('api')->user()->update($request->all());

        return (new \App\Http\JsonResponse)->success('Profile Updated', new UserResource(auth('api')->user()));
    }

    public function favourites()
    {
        if (Auth::guard('api')->check()) {
            $property_list = DB::table('favorites')->select('property_id')
                ->where('user_id', Auth::guard('api')->user()->id)->get()->pluck('property_id')->toArray();

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
    }

//    public function AddFavourite(Request $request)
//    {
//        if ($p = $request->property_id) {
//            $property = Property::find($p);
//            if ($property) {
//                $property->increment('favorites');
//                DB::table('favorites')
//                    ->Insert(['user_id' => Auth::user()->getAuthIdentifier(), 'property_id' => $property->id]);
//
//            } else {
//                return (new \App\Http\JsonResponse)->resourceNotFound();
//            }
//
//        } else
//            return (new \App\Http\JsonResponse)->unprocessable();
//
//    }

    public function RemoveFavourite(Request $request)
    {
        if ($p = $request->property_id) {
            $property = Property::find($p);
            if ($property) {

            } else {
                return (new \App\Http\JsonResponse)->resourceNotFound();
            }

        } else
            return (new \App\Http\JsonResponse)->unprocessable();

    }
}
