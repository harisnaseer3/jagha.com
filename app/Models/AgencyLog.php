<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */

class AgencyLog extends Model
{
    use SoftDeletes;

    public $fillable = [
        'admin_id',
        'agency_id',
        'agency_title',
        'status',
        'admin_name',
        'rejection_reason',
    ];

}
