<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Builder
 */
class Subscriber extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'email', 'status',
    ];

    public static $rules = [
        'email' => 'required|email',
    ];


}
