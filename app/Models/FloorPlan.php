<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class FloorPlan extends Model
{
    use SoftDeletes;

    public $table = 'floor_plans';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'property_id',
        'title',
        'name',
    ];

    public static $rules = [
        'name.*' => 'image|mimes:jpeg,png,jpg',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
