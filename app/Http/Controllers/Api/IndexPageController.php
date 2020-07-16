<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Commercial;
use App\Models\Dashboard\Home;
use App\Models\Dashboard\Plot;
use App\Models\Dashboard\User;
use App\Models\Property;
use Illuminate\Http\Request;

class IndexPageController extends Controller
{
    function getPropertyTypes()
    {
        $home_types = (new Home)->select('type')->distinct()->get();
        $plot_types = (new Plot)->select('type')->distinct()->get();
        $commercial_types = (new Commercial)->select('type')->distinct()->get();
        return response()->json([
            'data' => [
                'home_type' => $home_types,
                'plot_type' => $plot_types,
                'commercial_type' => $commercial_types
            ]
        ]);
    }

    public function getPropertyListing(string $type)
    {
        $properties = '';
        if ($type === 'houses') $properties = (new Property)->select('*')->where('type', '=', 'Homes')->paginate(10);
        else if ($type === 'plots') $properties = (new Property)->select('*')->where('type', '=', 'Plots')->paginate(10);
        else $properties = (new Property)->select('*')->where('type', '=', 'Commercial')->paginate(10);

        foreach ($properties as $property) {
            $property->city = $property->location->city->name;
            $property->location = $property->location->name;
            $property->image = Property::find($property->id)->images()->where('name', '<>', 'null')->get(['name', 'id'])->toArray();
            $user = (new User)->select('name')->where('id', '=', $property->user_id)->first();
            $property->user = $user->name;
        }
//        dd($properties);
//        return view('website.pages.properties_listing', ['properties' => $properties]);

        return response()->json([
            'data' => $properties
        ]);
    }
}
