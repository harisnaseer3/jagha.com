<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Classes\countries;
use App\Http\Controllers\Controller;
use App\Models\Log\LogVisitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function get($args = array())
    {

        // Check Number of Country
        if (!isset($args['limit'])) {
            $args['limit'] = 10;
        }
        $response = $this->getTop($args);

        // Check For No Data Meta Box
        if (count($response) < 1) {
            $response['no_data'] = 1;
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

        $result = $result->limit($args['limit'])->get();
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

    public function getList()
    {
        $ISOCountryCode = (new \App\Classes\countries)->list();
        if (isset($ISOCountryCode)) {
            return $ISOCountryCode;
        }

        return array();
    }


}
