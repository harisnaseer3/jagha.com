<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Crawler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

/**
 * @mixin Builder
 */
class Visit extends Model
{

    use SoftDeletes;

    public $attributes = ['count' => 0];

    protected $fillable = ['ip', 'date', 'visit_time', 'count', 'min_count'];
    protected $table = 'visits';

    public static function hit()
    {

        if (!Crawler::isCrawler()) {
            $user_visit = DB::table('visits')->where('ip', '=', $_SERVER['REMOTE_ADDR'])->where('date', '=', date('Y-m-d'))
                ->whereBetween('visit_time', [(new Carbon(date('H:i:s')))->subMinutes(1)->format('H:i:s'), date('H:i:s')])->first();
            if ($user_visit) {
                if ($user_visit->min_count <= 100) {
                    $user_visit->min_count++;
                    $user_visit->save();
                    return true;
                } else {
                    $user_visit->min_count = 0;
                    $user_visit->count--;
                    $user_visit->save();
                    return false;
                }
            } else {
                $visit = (new Visit)->where('ip', '=', $_SERVER['REMOTE_ADDR'])->where('date', '=', date('Y-m-d'))->first();
                if ($visit) {
                    $visit->visit_time = date('H:i:s');
                    $visit->count++;
                    $visit->save();
                } else {
                    (new Visit)->insert(['ip' => $_SERVER['REMOTE_ADDR'],
                        'date' => date('Y-m-d'), 'min_count' => 1,
                        'visit_time' => date('H:i:s'), 'count' => 1]);
                }
                return true;
            }
        }

//        handle bots

    }
}
