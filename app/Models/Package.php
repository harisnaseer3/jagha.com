<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/*
 * @mixin Builder
 */

class Package extends Model
{
    use SoftDeletes;

    //
    protected $fillable = ['user_id', 'type', 'activated_at', 'expired_at', 'package_for', 'admin_id', 'property_count', 'duration'];
    protected $table = 'packages';


    public static $rules = [
//        'package_for' => 'required|string|in:Properties,Agency',
        'property_count' => 'required|min:1',
        'duration' => 'required|min:1',
        'package' => 'required'
    ];

    function getPackageFromId($id)
    {
        return Package::where('id', $id)->first();
    }

    function getAgencyFromPackageID($package)
    {

        return DB::table('package_agency')->select('agency_id')->where('package_id', $package)->first();
    }


    function getPropertiesFromPackageID($package)
    {

        return DB::table('package_properties')->select('property_id')->where('package_id', $package)->get()->pluck('property_id')->toArray();
    }

    function getDuration($property)
    {

        return DB::table('package_properties')->select('duration')->where('property_id', $property)->first();
    }


}
