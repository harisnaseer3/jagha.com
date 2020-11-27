<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin Builder
 */
class TempImage extends Model
{
    use SoftDeletes;

    public $table = 'temp_images';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected
        $fillable = [
        'user_id', 'name', 'expiry_time'
    ];

    public static $rules = [
        'image.*' => 'image|max:10000',
    ];

    public static function boot()
    {
        parent::boot();
        // Any time the instance is updated (but not created)
//        static::saving(function ($tracker) {
//            $tracker->visit_time = date('H:i:s');
//            $tracker->count++;
//        });
    }

    public static function hit($name)
    {
        $dt = Carbon::now();

        $expiry = $dt->addHour()->toDateTimeString();
//        $expiry = $dt->addMonths(3)->toDateTimeString();
        (new TempImage)->firstOrCreate([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'name' => $name,
            'expiry_time' => $expiry,
        ])->save();
    }
}

