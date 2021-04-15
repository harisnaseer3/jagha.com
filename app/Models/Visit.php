<?php

namespace App\Models;

use App\Http\Controllers\CountryController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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
            $ip = $_SERVER['REMOTE_ADDR'];
            $visit = (New Visit())->where('ip', '=', $ip)
                ->where('date', '=', date('Y-m-d'))->first();
            if ($visit) {
                $visit->visit_time = date('H:i:s');
                $visit->count++;
                $visit->save();
            } else {

                $country = '';
                if ($ip_location = IpLocation::get($ip)) {
                    $country = $ip_location->countryName;
                    if ($country == null)
                        $country = (new CountryController())->Country_name();
                } else {
                    $country = 'unavailable';
                }
                (new Visit)->insert(
                    [   'ip' => $ip,
                        'ip_location' => $country,
                        'date' => date('Y-m-d'),
                        'min_count' => 1,
                        'visit_time' => date('H:i:s'),
                        'count' => 1
                    ]);
            }
        }


    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
