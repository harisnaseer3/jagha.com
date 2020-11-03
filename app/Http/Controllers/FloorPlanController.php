<?php

namespace App\Http\Controllers;

use App\Models\FloorPlan;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class FloorPlanController extends Controller
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
    public function store(Request $request, $property)
    {
        foreach (request()->file('floor_plans') as $file_name) {
            $filename = rand(0, 99);
            $extension = 'webp';

            $filenamewithoutext = $filename . time();
            $filenametostore = $filenamewithoutext . '.' . $extension;
            $files = [['width' => 750, 'height' => 600]];

            foreach ($files as $file) {
                $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;
                Storage::put('floor_plans/' . $filenametostore, fopen($file_name, 'r+'));

                //Resize image here
                $thumbnailpath = ('thumbnails/floor_plans/' . $updated_path);

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 1);

                $img->save($thumbnailpath);
            }

            $user_id = Auth::user()->getAuthIdentifier();

            (new FloorPlan)->updateOrCreate(['property_id' => $property->id, 'name' => $filenametostore], [
                'user_id' => $user_id,
                'property_id' => $property->id,
                'title' => 'Floor Plan',
                'name' => $filenametostore
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\FloorPlan $floorPlan
     * @return \Illuminate\Http\Response
     */
    public function show(FloorPlan $floorPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\FloorPlan $floorPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(FloorPlan $floorPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FloorPlan $floorPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        foreach (request()->file('floor_plans') as $file_name) {
            $filename = rand(0, 99);
            $extension = 'webp';

            $filenamewithoutext = $filename . time();
            $filenametostore = $filenamewithoutext . '.' . $extension;
            $files = [['width' => 750, 'height' => 600]];

            foreach ($files as $file) {
                $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;
                Storage::put('floor_plans/' . $filenametostore, fopen($file_name, 'r+'));

                //Resize image here
                $thumbnailpath = ('thumbnails/floor_plans/' . $updated_path);

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 1);

                $img->save($thumbnailpath);
            }

            $user_id = Auth::user()->getAuthIdentifier();

            (new FloorPlan)->updateOrCreate(['property_id' => $property->id, 'name' => $filenametostore], [
                'user_id' => $user_id,
                'property_id' => $property->id,
                'title' => 'Floor Plan',
                'name' => $filenametostore
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\FloorPlan $floorPlan
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $plans = (new FloorPlan)->find($request->input('image-record-id'));

        if ($plans->exists) {
            try {
                $plans->delete();
                return redirect()->back()->with('success', 'Image deleted successfully');

            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Image not found');
            }
        }
        return redirect()->back()->with('error', 'Image not found');
    }
}
