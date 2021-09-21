<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @mixin Builder
 */

class RecentlyViewedProperty extends Model
{
    use SoftDeletes;
    use SoftDeletes;

    public $table = 'recently_viewed_properties';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = [];

}
