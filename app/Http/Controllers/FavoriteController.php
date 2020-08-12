<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function store(Property $property)
    {
        dd($property->id);
        $favorites = $property->favorites;
        $property->favorites = $favorites + 1;
        $property->save();
        DB::table('favorites')
            ->updateOrInsert(
                ['user_id' => Auth::user()->getAuthIdentifier(), 'property_id' => $property->id], []);
        return response()->json(['data' => ['favorite' => 'added']]);
    }

    public function destroy(Property $property)
    {
        $favorites = $property->favorites;
        $property->favorites = $favorites - 1;
        $property->save();

        DB::table('favorites')->where([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'property_id' => $property->id
        ])->delete();
        return response()->json(['data' => ['favorite' => 'deleted']]);
    }

}
