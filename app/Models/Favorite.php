<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class Favorite extends Model
{

    protected $table = 'favorites';
    public $fillable = [
        'user_id',
        'property_id',

    ];

    public function property()
    {
        return $this->hasOne(Property::class);
    }
}
