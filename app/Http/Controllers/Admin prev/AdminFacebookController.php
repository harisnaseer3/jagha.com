<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\FacebookPost;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminFacebookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create()
    {
        return view('website.admin-pages.create-facebook-post');
    }

    public function store(Request $request)
    {
//        dd($request->id);

        $property = Property::where('id', $request->id)->first();
        if ($property) {
            $this->dispatch(new FacebookPost($property));
            return redirect()->route('admin.facebook.create')->with('success', 'Post for property id ' . $property->id . ' successfully made.');


        } else
            return redirect()->route('admin.facebook.create')->with('error', 'Property Not Found.');
    }
}
