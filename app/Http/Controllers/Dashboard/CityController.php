<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return (view('city.index', ['table_name' => 'cities', 'table_data_values' => City::all()]));
    }

    public function create()
    {
        $available_type = [
            'available_cities' => City::citiesList()->pluck('name')
        ];
        return view('city.create', ['table_name' => 'cities', 'lists' => $available_type]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), City::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error in storing record, try again.');
        }
        try {
            $city = (New City)->updateOrCreate(['name' => $request->input('name')], [
                'name' => $request->input('name'),
                'is_active' => $request->input('is_active'),
            ]);
            return redirect()->route('cities.show', ['city' => $city->id])->with('success', 'Item store successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'No record inserted !');
        }
//        (New City)->updateOrCreate(['name' => $request->input('city')], [
//            'name' => $request->input('name'),
//            'is_active' => $request->input('is_active'),
//        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Dashboard\City $city
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(City $city)
    {
        if ($city->exists) {
            try {
                return view('city.show', ['table_name' => 'cities', 'table_data_values' => $city]);
            } catch (\Throwable $e) {
                return redirect()->route('cities.index')->with('error', 'Record not found');
            }
        }
        return redirect()->route('cities.index')->with('error', 'Record not found');
    }

    public function edit(City $city)
    {
        $available_type = [
            'available_cities' => City::citiesList()->pluck('name')
        ];
        return view('city.edit', ['table_name' => 'cities', 'city' => $city, 'lists' => $available_type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dashboard\City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), City::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error updating record, try again.');
        }
        try {
            $city = (New City)->updateOrCreate(['name' => $request->input('name')], [
                'name' => $request->input('name'),
                'is_active' => $request->input('is_active'),
            ]);
            return redirect()->route('cities.show', ['city' => $city->id])->with('success', 'Item store successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'No record inserted !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Dashboard\City $city
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $city = (new City)->find($request->input('record_id'));

        if ($city->exists) {
            try {
                $city->delete();
                return redirect()->route('cities.index')->with('success', 'Record deleted successfully');

            } catch (\Exception $e) {
                return redirect()->route('cities.index')->with('error', 'Record not found');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }
}
