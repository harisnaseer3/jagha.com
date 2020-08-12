<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function store(Property $property)
    {
        DB::table('properties')->where('id', '=', $property->id)->increment('favorites');
        DB::table('favorites')
            ->Insert(['user_id' => Auth::user()->getAuthIdentifier(), 'property_id' => $property->id]);
        return response()->json(['data' => ['favorite' => 'added']]);
    }

    public function destroy(Property $property)
    {
        DB::table('properties')->where('id', '=', $property->id)->decrement('favorites');


        DB::table('favorites')->where([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'property_id' => $property->id
        ])->delete();
        return response()->json(['data' => ['favorite' => 'deleted']]);
    }

}
