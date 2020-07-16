<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class Video extends Model
{
    use SoftDeletes;

    public $table = 'videos';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'user_id',
        'property_id',
        'name',
        'host'
    ];

    public static $rules = [
        'name' => 'url'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
