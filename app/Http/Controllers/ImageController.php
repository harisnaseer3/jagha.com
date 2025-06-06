<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Intervention\Image\Exception\NotReadableException;


class ImageController extends Controller
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
        foreach (request()->file('image') as $file_name) {
            $filename = rand(0, 99);
            $extension = 'webp';

            $filenamewithoutext = $filename . time();
            $filenametostore = $filenamewithoutext . '.' . $extension;
            $files = [['width' => 750, 'height' => 600], ['width' => 450, 'height' => 350], ['width' => 200, 'height' => 200]];

            foreach ($files as $file) {
                $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;
                Storage::put('properties/' . $updated_path, fopen($file_name, 'r+'));

                //Resize image here
                $thumbnailpath = ('thumbnails/properties/' . $updated_path);

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 1);

                $img->save($thumbnailpath);
            }
            $user_id = Auth::user()->getAuthIdentifier();

            (new Image)->updateOrCreate(['property_id' => $property->id, 'name' => $filenametostore], [
                'user_id' => $user_id,
                'property_id' => $property->id,
                'name' => $filenametostore
            ]);
        }
    }

    public function storeImage($name, $property)
    {
        foreach (json_decode($name, true) as $file_name) {
            foreach ($file_name as $key => $value) {
                $img_name = str_replace('"', '', $key);
                (new Image)->updateOrCreate(
                    ['user_id' => $property->user_id, 'property_id' => $property->id, 'name' => $img_name],
                    ['user_id' => $property->user_id,
                        'property_id' => $property->id,
                        'name' => $img_name,
                        'order' => (int)$file_name[$key]
                    ]);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property)
    {
        foreach (request()->file('image') as $file_name) {
            $filename = rand(0, 99);
            $extension = 'webp';

            $filenamewithoutext = $filename . time();
            $filenametostore = $filenamewithoutext . '.' . $extension;
            $files = [['width' => 750, 'height' => 600], ['width' => 450, 'height' => 350], ['width' => 200, 'height' => 200]];

            foreach ($files as $file) {
                $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;
                Storage::put('properties/' . $updated_path, fopen($file_name, 'r+'));

                //Resize image here
                $thumbnailpath = ('thumbnails/properties/' . $updated_path);

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 1);

                $img->save($thumbnailpath);
            }
            $user_id = Auth::user()->getAuthIdentifier();

            (new Image)->updateOrCreate(['property_id' => $property->id, 'name' => $filenametostore], [
                'user_id' => $user_id,
                'property_id' => $property->id,
                'name' => $filenametostore
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Image $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function form_destroy(Request $request)
    {
        $images = (new Image)->find($request->input('image-record-id'));
        if ($images->exists) {
            try {
                $images->delete();
                return redirect()->back()->with('success', 'Image deleted successfully');

            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Image not found');
            }
        }
        return redirect()->back()->with('error', 'Image not found');
    }

    public function destroy(Image $image)
    {
        if ($image->exists) {
            try {
                $image->delete();
                return response()->json(['data' => 'images deleted', 'status' => 200]);
            } catch (Throwable $e) {
                return response()->json(['data' => $e->getMessage(), 'status' => 404]);

            }
        }
    }

}
