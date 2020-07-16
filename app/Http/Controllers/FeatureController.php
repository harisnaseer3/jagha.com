<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Property;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        //
    }

    //    function used to get features of selected property
    function getFeatures(Request $request)
    {
        if ($request->ajax()) {
            if ($request->filled('index')) {
                $features = (new Feature)->select('list')->where('name', '=', $request->input('name'))->first();
                $values = (new Property)->select('features')->where('id', '=', $request->input('index'))->first();
                return response()->json(['data' => $features, 'values' => $values, 'status' => 200]);
            } else {
                $features = (new Feature)->select('list')->where('name', '=', $request->input('name'))->first();
                return response()->json(['data' => $features, 'status' => 200]);
            }
        } else {
            return "not found";
        }
    }
}
