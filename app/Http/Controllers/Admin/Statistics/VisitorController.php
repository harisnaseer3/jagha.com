<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Classes\countries;
use App\Classes\Referred;
use App\Http\Controllers\Controller;
use App\Models\Log\LogVisitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function get($args = array())
    {
        if (!isset($args['limit'])) {
            $args['limit'] = 10;
        }
        if (!isset($args['day'])) {
            $args['day'] = 'today';
        }
        try {
            $response = $this->getTop($args);
        } catch (\Exception $e) {
            $response = array();
        }
        // Check For No Data Meta Box
        if (count($response) < 1) {
            $response = array();
        }

        // Response
        return $response;
    }

    public function getRecentVisitor($args = array())
    {
        if (!isset($args['limit'])) {
            $args['limit'] = 10;
        }

        try {
            $response = $this->getRecent($args);
        } catch (\Exception $e) {
            $response = array();
        }
        // Check For No Data Meta Box
        if (count($response) < 1) {
            $response = array();
        }

        // Response
        return $response;
    }


    public function getTop($args)
    {
        // Get List From DB
        $t = Carbon::now()->format('Y-m-d');
        if ($args['day'] != 'today') {
            $t = date('Y-m-d', strtotime($args['day']));
        }

        //TODO: remove this after demo
        $t = '2021-04-18';

        $list = array();


        $result = (new LogVisitor())->select('*')->where('last_counter', $t)->orderBy('hits', 'DESC')->limit($args['limit'])->get();

        if (!$result->isEmpty()) {
            $list= self::prepareData($result);
        }
        return $list;
    }

    public function getRecent($args)
    {

        $list = array();
        $result = (new LogVisitor())->select('*')->orderBy('ID', 'DESC')->limit($args['limit'])->get();

        if (!$result->isEmpty()) {
            $list = self::prepareData($result);
        }
        return $list;
    }

    /**
     * Get Page Information By visitor ID
     *
     * @param $visitor_ID
     * @return mixed
     */
//    public static function get_page_by_visitor_id($visitor_ID)
//    {
//
//        // Default Params
//        $params = array('link' => '', 'title' => '');
//
//
//
//        // Get Row
//        $item = " SELECT " . DB::table('pages') . ".* FROM `" . DB::table('pages') . "` INNER JOIN `" . DB::table('visitor_relationships') . "` ON `" . DB::table('pages') . "`.`page_id` = `" . DB::table('visitor_relationships') . "`.`page_id` INNER JOIN `" . DB::table('visitor') . "` ON `" . DB::table('visitor_relationships') . "`.`visitor_id` = `" . DB::table('visitor') . "`.`ID` WHERE `" . DB::table('visitor') . "`.`ID` = {$visitor_ID};", ARRAY_A);
//        if ($item !== null) {
//            $params = Pages::get_page_info($item['id'], $item['type']);
//        }
//
//        return $params;
//    }

    public  function prepareData($result): array
    {
        $list = array();
        foreach ($result as $items) {
            $item = array(
                'hits' => (int)$items->hits,
                'referred' => Referred::get_referrer_link($items->referred),
                'refer' => $items->referred,
                'date' => (new Carbon($items->last_counter))->Format('M d, Y'),
                'agent' => $items->agent,
                'platform' => $items->platform,
                'version' => $items->version
            );
            $item['browser'] = array(
                'name' => $items->agent,
            );
            // Push IP
            $item['ip'] = $items->ip;

            // Push Country
            $item['country'] = array('location' => $items->location, 'name' => (new CountryController())->getName($items->location));
            $item['city'] = 'Unknown';
            $list[] = $item;
        }
        return $list;
    }

}
