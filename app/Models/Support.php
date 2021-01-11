<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @mixin Builder
 */

class Support extends Model
{
    use SoftDeletes;

    public $table = 'supports';

    protected $fillable = [
        'user_id', 'url', 'message', 'inquire_about', 'property_id', 'agency_id'
    ];

    public static $rules = [
        'message' => 'string|required|max:1024|min:25',
        'inquire_about' => 'required|in:Property,Agency',
        'property_id' => 'required_if:inquire_about,==,Property',
        'agency_id' => 'required_if:inquire_about,==,Agency',
        'url' => 'nullable|url',
    ];
}
