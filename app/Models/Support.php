<?php

namespace App\Models;

use App\Models\Dashboard\User;
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
        'user_id', 'url', 'message', 'inquire_about', 'property_id', 'agency_id', 'topic', 'ticket_id'
    ];

    public static $rules = [
        'message' => 'string|required|max:1024|min:25',
        'inquire_type' => 'required|in:Property,Agency,Other',
        'topic' => 'required_if:inquire_about,=,Other',
        'url' => 'nullable|url',
    ];

    public static function getSupportById($id)
    {
        return Support::where('id', $id)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getSupportByType($type)
    {
        return (new Support)->where('inquire_about', $type)->orderBy('id', 'DESC')->count();

    }


    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
