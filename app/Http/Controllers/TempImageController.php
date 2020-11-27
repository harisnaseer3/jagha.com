<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TempImageController extends Controller
{
    public function ajaxImageUpload(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('image')) {
                $result = $this->_imageValidation();
                if (!empty($result)) {
                    return response()->json(['status' => 201, 'data' => $result]);
                } else {
                    $file_name = $this->store();
                    return response()->json(['status' => 200, 'data' => $file_name]);
                }

            }
        }
    }

    private function store()
    {
//        foreach (request()->file('image') as $file_name) {
        $file_name = request()->file('image');
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
        (new TempImage)->hit($filenametostore);
        return $filenametostore;
    }

    private function _imageValidation()
    {
        $error_msg = [];
        $mime = request()->file('image')->getMimeType();
        $supported_mime_types = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!in_array($mime, $supported_mime_types)) {
            $error_msg = 'Error: Image must be a file of type: jpeg, png, jpg.';
        }
        return $error_msg;
    }
}
