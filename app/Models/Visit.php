<?php

namespace App\Models;

use App\Http\Controllers\CountryController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use IpLocation;

/**
 * @mixin Builder
 */
class Visit extends Model
{

    use SoftDeletes;

    public $attributes = ['count' => 0];

    protected $fillable = ['ip', 'date', 'visit_time', 'count', 'min_count', 'ip_location'];
    protected $table = 'visits';

    public static function hit()
    {
        $CrawlerDetect = new CrawlerDetect;
        // Pass a user agent as a string
        if (!$CrawlerDetect->isCrawler()) {
//            $user_visit = (new Visit)->where('ip', '=', $_SERVER['REMOTE_ADDR'])->where('date', '=', date('Y-m-d'))
//                ->whereBetween('visit_time', [(new Carbon(date('H:i:s')))->subMinutes(1)->format('H:i:s'), date('H:i:s')])->first();
//            $user_visit = (new Visit)->where('ip', '=', $_SERVER['REMOTE_ADDR'])->where('date', '=', date('Y-m-d'))->first();
//            if ($user_visit) {
//                if ($user_visit->min_count <= 100) {
//                $user_visit->min_count++;
//                $user_visit->visit_time = date('H:i:s');
//                $user_visit->save();
//                return true;
//                }
//                else {
//                    $user_visit->min_count = 0;
//                    $user_visit->count--;
//                    $user_visit->save();
//                    return false;
//                }
//            } else {
                $visit = (new Visit)->where('ip', '=', $_SERVER['REMOTE_ADDR'])->where('date', '=', date('Y-m-d'))->first();
                if ($visit) {
                    $visit->visit_time = date('H:i:s');
                    $visit->count++;
                    $visit->save();
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $country = '';
                    if ($ip_location = IpLocation::get($ip)) {
                        $country = $ip_location->countryName;
                        if ($country == null)
                            $country = (new CountryController())->Country_name();
                    } else {

                        $country = 'unavailable';
                    }
                    (new Visit)->insert(
                        [
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'ip_location' => $country,
                            'date' => date('Y-m-d'),
                            'min_count' => 1,
                            'visit_time' => date('H:i:s'),
                            'count' => 1
                        ]);
                }
                return true;
            }
//        } else {
//            return true;
//        }

//        handle bots

    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
