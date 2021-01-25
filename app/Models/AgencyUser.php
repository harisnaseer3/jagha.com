<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @mixin Builder
 */
class AgencyUser extends Model
{
    use SoftDeletes;
    public $table = 'agency_users';

    public function user()
    {
        return $this->belongsTo('App\Models\Dashboard\User','user_id');
    }
    public function agency()
    {
        return $this->belongsTo('App\Models\Agency','agency_id');
    }
    //
}
