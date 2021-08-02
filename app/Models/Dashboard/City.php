<?php

namespace App\Models\Dashboard;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class City extends Model
{
    use SoftDeletes;

    public $table = 'cities';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'is_active'
    ];

    public static $rules = [
        'name' => 'required|max:225',
        'is_active' => 'required|boolean',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class, 'city_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'city_id');
    }

    public static function citiesList()
    {
        return (new City)->select('name')->distinct();
    }
}
