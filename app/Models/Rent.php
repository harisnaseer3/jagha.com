<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @mixin Builder
 */
class Rent extends Model
{
    use SoftDeletes;
    //
}
