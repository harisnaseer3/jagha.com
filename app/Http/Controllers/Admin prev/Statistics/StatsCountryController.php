<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Classes\Countries;
use App\Http\Controllers\Controller;
use App\Models\Log\LogVisitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StatsCountryController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:admin');
//    }

    /**
     * Default Unknown flag
     *
     * @var string
     */
    public static $unknown_location = 'UNKNOWN';

    public function get($args = array())
    {

        // Check Number of Country
        if (!isset($args['limit'])) {
            $args['limit'] = 10;
        }
        $response = $this->getTop($args);

        // Check For No Data Meta Box
        if (count($response) < 1) {
            $response = array();
        }

        // Response
        return $response;
    }

    public function getTop($args)
    {
        $ISOCountryCode = $this->getList();
        // Get List From DB

        $list = array();

        // Get Result
        $result = (new LogVisitor())->select(DB::raw('COUNT(location) AS count'), 'location');
        if (isset($args['from']) and isset($args['to'])) {
            $result = $result->whereBetween('last_counter', [$args['from'], $args['to']]);

        }
        $result = $result->orderBy('count', 'DESC')->groupBy('location');

        $result = $result->get();
        if (!$result->isEmpty()) {
            foreach ($result as $item) {
                $item->location = strtoupper($item->location);
                $list[] = array(
                    'location' => $item->location,
                    'name' => $ISOCountryCode[$item->location],
//                    'flag' => self::flag($item->location),
//                    'link' => Menus::admin_url('visitors', array('location' => $item->location)),
                    'number' => $item->count
                );
            }
        }

        return $list;
    }


    /**
     * Get Country name by Code
     *
     * @param $code
     * @return mixed
     */
    public static function getName($code)
    {
        $list_country = (new StatsCountryController)->getList();
        if (array_key_exists($code, $list_country)) {
            return $list_country[$code];
        }

        return $list_country[self::$unknown_location];
    }

    public function getList()
    {
        $ISOCountryCode = (new \App\Classes\Countries)->list();
        if (isset($ISOCountryCode)) {
            return $ISOCountryCode;
        }

        return array();
    }
}
