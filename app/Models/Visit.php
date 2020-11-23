<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class Visit extends Model
{

    use SoftDeletes;

    public $attributes = ['count' => 0];

    protected $fillable = ['ip', 'date', 'visit_time', 'count'];
    protected $table = 'visits';

    public static function boot()
    {
        parent::boot();
        // Any time the instance is updated (but not created)
        static::saving(function ($tracker) {
            $tracker->visit_time = date('H:i:s');
            $tracker->count++;
        });
    }

    public static function hit()
    {
        (new Visit)->firstOrCreate([
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => date('Y-m-d'),
        ])->save();
    }
}
