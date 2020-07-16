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
        foreach (request()->file('image') as $file) {
            $filename = rand(0, 99);
            $extension = 'webp';

            //filename to store 150x150
            $filenametostore = $filename .'-'. time() . '-750x600.' . $extension;


            Storage::put('public/properties/' . $filenametostore, fopen($file, 'r+'));
//            Storage::put('public/img/properties/thumbnail/' . $filenametostore, fopen($file, 'r+'));

            //Resize image here
            $thumbnailpath = public_path('storage/properties/' . $filenametostore);

            $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit(750, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 1);

            $img->save($thumbnailpath);
            $user_id = Auth::check() ? Auth::user()->getAuthIdentifier() : 1;

            (new Image)->updateOrCreate(['property_id' => $property->id, 'name' => $filenametostore], [
                'user_id' => $user_id,
                'property_id' => $property->id,
                'name' => $filenametostore
            ]);
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
        foreach (request()->file('image') as $file) {
            $filename = rand(0, 99);

            //get file extension
            $extension = 'webp';

            //filename to store
            $filenametostore = $filename .'-'. time() . '-750x600.' . $extension;

            Storage::put('public/properties/' . $filenametostore, fopen($file, 'r+'));

            //Resize image here
            $thumbnailpath = public_path('storage/properties/' . $filenametostore);

            $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit(750, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 1);

            $img->save($thumbnailpath);
            $user_id = Auth::check() ? Auth::user()->getAuthIdentifier() : 1;

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
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
}
