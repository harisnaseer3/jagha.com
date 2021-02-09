<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Dashboard\City;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class LocationController extends Controller
{
    public function index()
    {
        $table_values = Location::all();
        foreach ($table_values as $key => $value) {
            if (is_object($value->city))
                continue;
            else
                unset($table_values[$key]);
        }
        return view('location.index', ['table_name' => 'locations', 'table_data_values' => $table_values]);
    }

    public function create()
    {
        $available_type = [
            'available_locations' => Location::locationsList()->pluck('name'),
            'available_cities' => City::citiesList()->pluck('name')
        ];
        return view('location.create', ['table_name' => 'locations', 'lists' => $available_type]);
    }

    /**
     * Store a newly created resource in storage.
     *

     */
    public function store($loc, $city)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        try {
            $location = (new Location)->updateOrInsert(['city_id' => $city->id, 'name' => $loc], [
                'user_id' => $user_id,
                'city_id' => $city->id,
                'name' => $loc,
                'is_active' => '0',
            ])->first();
            return $location;
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Dashboard\Location $location
     * @return string
     */
    public function show(Location $location)
    {
        if ($location->exists) {
            try {
                $location->city_id = $location->city->name;
                return view('location.show', ['table_name' => 'locations', 'table_data_values' => $location]);
            } catch (\Throwable $e) {
                return redirect()->route('locations.index')->with('error', 'Record not found');
            }
        }

        return redirect()->route('locations.index')->with('error', 'Record not found');
    }

    public function edit(Location $location)
    {
        $location->city = $location->city->name;
        $available_type = [
            'available_locations' => Location::locationsList()->pluck('name'),
            'available_cities' => City::citiesList()->pluck('name')
        ];
        return view('location.edit', ['table_name' => 'locations', 'location' => $location, 'lists' => $available_type]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dashboard\Location $location
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $city)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        $location = (new Location)->updateOrCreate(['name' => $request->input('location'), 'city_id' => $city->id], [
            'user_id' => $user_id,
            'city_id' => $city->id,
            'name' => $request->input('location'),
        ]);
        return ['location_id' => $location->id, 'location_name' => $location->name];
    }

    public function activate_location($location)
    {
//        (new Location)->update(['id' => $location], [
//            'is_active' => '1'
//        ]);
//        DB::table('locations')
//            ->where('id', $location)
//            ->update(['is_active' => '1']);
        $location->is_active = '1';
        $location->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Dashboard\Location $location
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $location = (new Location)->find($request->input('record_id'));

        if ($location->exists) {
            try {
                $location->delete();
                return redirect()->route('locations.index')->with('success', 'Record deleted successfully');

            } catch (\Exception $e) {
                return redirect()->route('locations.index')->with('error', 'Record not found');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }

    //    function used to get the datalist of location txt field on index page
    function cityLocations(Request $request)
    {
        if ($request->ajax()) {
            $city_id = (new City)->select('id')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();
            $location = (new Location)->select('name')->where('city_id', '=', $city_id->id)->where('is_active', '=', '1')->get()->toArray();

            return response()->json(['data' => $location, 'status' => 200]);

        } else {
            return "not found";
        }
    }
}
