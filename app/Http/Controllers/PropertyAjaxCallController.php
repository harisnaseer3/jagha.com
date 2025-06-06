<?php

namespace App\Http\Controllers;

use App\Events\NotifyAdminOfNewProperty;
use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationOnPropertyUpdate;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Notifications\PropertyStatusChange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropertyAjaxCallController extends Controller
{
    //  ajax calls
    public function getAreaValue(Request $request)
    {
        if ($request->ajax()) {
            $result = (new Property)->select('land_area')->WHERE('area_unit', '=', $request->area_unit)->distinct()->inRandomOrder()->orderBy('land_area', 'ASC')->limit(8)->get()->toArray();
            return response()->json(['data' => $result, 'status' => 200]);
        } else {
            return "not found";
        }
    }

    public function changePropertyStatus(Request $request)
    {
        if ($request->ajax()) {
            $property = (new Property)->WHERE('id', '=', $request->id)->first();
            if (Auth::guard('web')->check()) {
                if (!(Property::getPropertyUpdateCountById($property))) {
                    return response()->json(['status' => 201, 'message' => 'Maximum Update Limit Reached for Property ID: ' . $property->id]);
                }

            }

            (new CountTableController)->_delete_in_status_purpose_table($property, $property->status);

            $property->update([
                'status' => $request->status,
                'activated_at' => null,
                'expired_at' => $request->status == 'expired' ? date('Y-m-d H:i:s') : null,
            ]);
            $city = (new City)->select('id', 'name')->where('id', '=', $property->city_id)->first();
            $location = (new Location)->select('id', 'name')->where('id', '=', $property->location_id)->first();

            $this->dispatch(new SendNotificationOnPropertyUpdate($property));

            if ($property->status == 'pending')
                event(new NotifyAdminOfNewProperty($property));


            (new CountTableController)->_insert_in_status_purpose_table($property);

            if ($request->status == 'sold' || $request->status == 'expired') {
                (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $property);

                if (Auth::guard('admin')->user()) {
                    (new PropertyLogController())->store($property);
                }

            }
            return response()->json(['status' => 200]);
        } else {
            return "not found";
        }
    }

    public function adminPropertySearch(Request $request)
    {
        $property = (new Property)->where('id', '=', $request->property_id)->first();
        if (!$property)
            return redirect()->back()->withInput()->with('error', 'Property not found.');
        else {
            $status = lcfirst($property->status);
            $purpose = lcfirst($property->purpose);

            return redirect()->route('admin.properties.listings',
                ['status' => $status, 'purpose' => $purpose, 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(),
                    'sort' => 'id', 'order' => 'desc', 'page' => 50, 'id' => $request->property_id]);
        }

    }

    public function adminPropertyCitySearch(Request $request)
    {
        $city = (new City)->select('id')->where('name', '=', $request->city)->first();
        if (is_null($city))
            return redirect()->back()->withInput()->with('error', 'No Properties found in ' . $request->city . '.');
        else {
            return redirect()->route('admin.properties.listings',
                ['status' => 'all', 'purpose' => 'all', 'user' => \Illuminate\Support\Facades\Auth::guard('admin')->user()->getAuthIdentifier(),
                    'sort' => 'id', 'order' => 'desc', 'page' => 50, 'city' => str_replace(' ', '-', $request->city)]);
        }

    }

    public function userPropertySearch(Request $request)
    {
        if ($request->input('property_ref') != null && preg_match('$(20\d{2}-)\d{8}$', $request->input('property_ref'))) {
            $property = (new Property)->where('reference', '=', $request->property_ref)->where('status', '=', 'active')->first();
            if (!$property)
                return redirect()->back()->withInput()->with('error', 'Property not found.');
            else {
                $status = lcfirst($property->status);
                $purpose = lcfirst($property->purpose);
                return redirect()->route('properties.listings',
                    ['status' => $status, 'purpose' => $purpose, 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),
                        'sort' => 'id', 'order' => 'desc', 'page' => 50, 'reference' => $request->property_ref]);
            }
        } else
            return redirect()->back()->withInput()->with('error', 'Please enter property reference.');
    }

    public function userPropertySearchById(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->input('property_id') != null && preg_match('/^[0-9]*$/', $request->input('property_id'))) {
            $property = (new Property)->where('id', '=', $request->property_id)->first();
            if (!$property)
                return redirect()->back()->withInput()->with('error', 'No Property found.');
            else {
                $status = lcfirst($property->status);
                $purpose = lcfirst($property->purpose);
                return redirect()->route('properties.listings',
                    ['status' => $status, 'purpose' => $purpose, 'user' => \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier(),
                        'sort' => 'id', 'order' => 'desc', 'page' => 10, 'user-property-id' => $request->property_id]);
            }
        } else
            return redirect()->back()->withInput()->with('error', 'Please Enter Valid Property ID.');
    }


    public function allAgencies(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('property')) {
                if (Property::where('id', $request->input('property'))->exists()) {

                    return response()->json(['agency' => (new Agency())->where('status', '=', 'verified')
                        ->select('agencies.id', 'agencies.title',
                            'agencies.address', 'agencies.cell', 'agencies.phone', 'cities.name AS city')
                        ->join('cities', 'cities.id', '=', 'agencies.city_id')
                        ->get()->toArray(), 'default_agency' => $request->input('id'), 'status' => 200]);
                }
            }  //get all agencies

            else {
                return response()->json(['agency' => (new Agency())->where('status', '=', 'verified')
                    ->select('agencies.id', 'agencies.title',
                        'agencies.address', 'agencies.cell', 'agencies.phone', 'cities.name AS city')
                    ->join('cities', 'cities.id', '=', 'agencies.city_id')
                    ->get()->toArray(), 'default_agency' => '', 'status' => 200]);
            }


//            dd($request->input('agency'));
        } else
            return 'not found';

    }

    public function mapCall(Request $request)
    {
        if ($request->ajax()) {
            DB::table('google_api_log')->where('id', 1)->increment('count', 1);
            return response()->json(['status' => 200, 'message' => 'Done']);
        } else return 'not found';
    }

}
