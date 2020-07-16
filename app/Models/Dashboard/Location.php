<?php

namespace App\Models\Dashboard;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Builder
 */
class Location extends Model
{
    use SoftDeletes;

    public $table = 'locations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'city_id',
        'name',
        'is_active'
    ];

    public static $rules = [
        'name' => 'required|max:225',
        'city' => 'required|max:255',
        'is_active' => 'required|boolean',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function properties()
    {
        return $this->belongsTo(Property::class);
    }

    public function homes()
    {
        return $this->hasMany(Home::class);
    }

    public function plots()
    {
        return $this->hasMany(Plot::class);
    }

    public function Commercials()
    {
        return $this->hasMany(Commercial::class);
    }

    public static function locationsList()
    {
        return (new Location)->select('name')->distinct();
    }


}
