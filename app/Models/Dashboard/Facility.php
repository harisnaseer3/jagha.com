<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class Facility extends Model
{
    use SoftDeletes;

    public $table = 'facilities';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'icon',
        'is_active'
    ];

    public static $rules = [
        'name' => 'required|max:225',
        'icon' => 'required|max:255',
        'is_active' => 'required|boolean',
    ];

    public static function iconList()
    {
        return (new Facility)->select('icon')->distinct();
    }
    public static function facilityList()
    {
        return (new Facility)->select('name')->distinct();
    }
}
