<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class Blog extends Model
{
    protected $connection = 'mysql2';

    public $table = 'wp_posts';
//    use SoftDeletes;
    //
}
