<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class PropertyLog extends Model
{
    use SoftDeletes;

    public $fillable = [
        'admin_id',
        'property_id',
        'status',
        'admin_name',
        'rejection_reason',
    ];
}
