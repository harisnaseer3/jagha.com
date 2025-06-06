<?php

namespace App\Http\Controllers\Api\WebServices\UserProfile;

use App\Http\Controllers\Api\WebServices\Property\PropertySearchController;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyListing as PropertyListingResource;
use App\Http\Resources\User as UserResource;
use App\Models\Account;
use App\Models\Property;
use Exception;
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

        (new Account)->updateOrCreate(['user_id' => auth::guard('api')->user()->getAuthIdentifier()], [
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
        if (auth::guard('api')->check()) {
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

    public function AddFavourite(Request $request)
    {
        if ($p = $request->property_id) {
            try {
                $property = Property::find($p);
                if ($property) {

                    $property->favorites = $property->favorites + 1;
                    $property->save();

                    DB::table('favorites')
                        ->Insert(['user_id' => auth::guard('api')->user()->getAuthIdentifier(), 'property_id' => $property->id]);
                    return (new \App\Http\JsonResponse)->success("Property added to favourites successfully");
                } else {
                    return (new \App\Http\JsonResponse)->resourceNotFound();
                }
            } catch (Exception $e) {
                return (new \App\Http\JsonResponse)->failed("Error storing search. Please try again");
            }


        } else
            return (new \App\Http\JsonResponse)->unprocessable();

    }

    public function RemoveFavourite($property_id)
    {

//        if ($property) {

        try {
            $property = Property::find($property_id);
            if ($property) {
                if (DB::table('favorites')->where([
                    'user_id' => auth::guard('api')->user()->getAuthIdentifier(),
                    'property_id' => $property->id
                ])->exists()) {
                    $property->favorites = $property->favorites - 1;
                    $property->save();


                    DB::table('favorites')->where([
                        'user_id' => auth::guard('api')->user()->getAuthIdentifier(),
                        'property_id' => $property->id
                    ])->delete();
                    return (new \App\Http\JsonResponse)->success("Property removed from favourites successfully");
                } else {
                    return (new \App\Http\JsonResponse)->resourceNotFound();
                }

            } else {
                return (new \App\Http\JsonResponse)->resourceNotFound();
            }
        } catch (Exception $e) {
            return (new \App\Http\JsonResponse)->failed("Error storing search. Please try again");
        }


//        } else
//            return (new \App\Http\JsonResponse)->unprocessable();

    }


    function listingFrontend()
    {
        return DB::table('properties')
            ->select('properties.id', 'properties.user_id', 'properties.purpose', 'properties.sub_purpose', 'properties.sub_type',
                'properties.type', 'properties.title', 'properties.description', 'properties.price', 'properties.land_area', 'properties.area_unit',
                'properties.bedrooms', 'properties.bathrooms', 'properties.golden_listing', 'properties.platinum_listing',
                'properties.contact_person', 'properties.phone', 'properties.cell', 'properties.fax', 'properties.email', 'properties.favorites',
                'properties.views', 'properties.status', 'f.user_id AS user_favorite', 'properties.created_at', 'properties.activated_at',
                'properties.updated_at', 'locations.name AS location', 'cities.name AS city', 'p.name AS image',
                'properties.area_in_sqft', 'area_in_sqyd', 'area_in_marla', 'area_in_kanal', 'area_in_sqm',
                'agencies.title AS agency', 'agencies.featured_listing', 'agencies.logo AS logo', 'agencies.key_listing',
                'agencies.status AS agency_status',
                'agencies.phone AS agency_phone', 'agencies.cell AS agency_cell', 'agencies.ceo_name AS agent', 'agencies.created_at AS agency_created_at',
                'agencies.description AS agency_description')
            ->leftJoin('images as p', function ($q) {
                $q->on('p.property_id', '=', 'properties.id')
                    ->on('p.name', '=', DB::raw('(select name from images where images.property_id = properties.id and images.deleted_at IS null ORDER BY images.order  limit 1 )'));
            })
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->leftjoin('agencies', 'properties.agency_id', '=', 'agencies.id')
            ->leftJoin('favorites as f', function ($f) {
                $f->on('properties.id', '=', 'f.property_id')
                    ->where('f.user_id', '=', Auth::guard('api')->user() ? Auth::user()->getAuthIdentifier() : 0);
            })
            ->join('users', 'properties.user_id', '=', 'users.id')
//            ->leftJoin('property_count_by_agencies as c', function ($c) {
//                $c->on('properties.agency_id', '=', 'c.agency_id')
//                    ->where('c.property_status', '=', 'active');
//            })
            ;

    }

    public function myProperties(Request $request)
    {
        $user = auth()->guard('api')->user();
        if (!$user->hasVerifiedEmail()) {
            return (new \App\Http\JsonResponse)->forbidden();
        }
        $status = null;
        $user_id = $user->id;
        if ($request->has('status'))
            $status = $request->status;
        if (isset($status)) {
            $properties = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', $status)->get();
            $my_properties = [
                $status => (new PropertyListingResource)->myToArray($properties)
            ];
            return (new \App\Http\JsonResponse)->success("User Properties", $my_properties);
        } else {
            $properties_pending = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', 'pending')->get();
            $properties_active = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', 'active')->get();
            $properties_rejected = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', 'rejected')->get();
            $properties_deleted = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', 'deleted')->get();
            $properties_expired = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', 'expired')->get();
            $properties_sold = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', 'sold')->get();
            $properties_draft = $this->listingFrontend()->where('properties.user_id', $user_id)->where('properties.status', 'draft')->get();

            $my_properties = [
                'active' => (new PropertyListingResource)->myToArray($properties_active),
                'pending' => (new PropertyListingResource)->myToArray($properties_pending),
                'rejected' => (new PropertyListingResource)->myToArray($properties_rejected),
                'expired' => (new PropertyListingResource)->myToArray($properties_expired),
                'deleted' => (new PropertyListingResource)->myToArray($properties_deleted),
                'sold' => (new PropertyListingResource)->myToArray($properties_sold),
                'draft' => (new PropertyListingResource)->myToArray($properties_draft)
            ];
            return (new \App\Http\JsonResponse)->success("User Properties", $my_properties);
        }


    }

    public function addUserSearch(Request $request)
    {
        if ($request->has('url') && $n = $request->has('name')) {

            try {
                DB::table('user_searches')
                    ->Insert([
                        'user_id' => auth::guard('api')->user()->getAuthIdentifier(),
                        'name' => $request->name,
                        'url' => $request->url
                    ]);
                return (new \App\Http\JsonResponse)->success("Search saved successfully");
            } catch (Exception $e) {
                print($e->getMessage());
                return (new \App\Http\JsonResponse)->failed("Error storing search. Please try again");
            }

        } else
            return (new \App\Http\JsonResponse)->unprocessable();


    }

    public function removeUserSearch($id)
    {
//        if ($id = $request->search_id) {
        try {
            if (DB::table('user_searches')->where([
                'user_id' => auth::guard('api')->user()->getAuthIdentifier(),
                'id' => $id
            ])->exists()) {
                DB::table('user_searches')->where('id', $id)->delete();
                return (new \App\Http\JsonResponse)->success("Search removed successfully");
            } else
                return (new \App\Http\JsonResponse)->unprocessable();
        } catch (Exception $e) {
            return (new \App\Http\JsonResponse)->failed("Error deleting search. Please try again");
        }
//        } else
//            return (new \App\Http\JsonResponse)->unprocessable();
    }

    public function getUserSaveSearches()
    {
        $results = DB::table('user_searches')
            ->select('id', 'url', 'name')->where('user_id', auth::guard('api')->user()->getAuthIdentifier())
            ->get()->toArray();


        return (new \App\Http\JsonResponse)->success("Saved Search Result", $results);


    }


}
