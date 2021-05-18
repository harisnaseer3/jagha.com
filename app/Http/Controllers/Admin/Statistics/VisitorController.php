<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Classes\Countries;
use App\Classes\Referred;
use App\Events\LogErrorEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HitRecord\HitController;
use App\Models\Log\LogVisitor;
use Barryvdh\Debugbar\Controllers\AssetController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use IpLocation;


class VisitorController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:admin');
//    }

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

        $list = array();


        $result = (new LogVisitor())->select('*')->where('last_counter', $t)->where('hits', '>', 1)->orderBy('hits', 'DESC')->get();

        if (!$result->isEmpty()) {
            $list = self::prepareData($result);
        }
        return $list;
    }

    public function getRecent($args)
    {

        if ($args['date'] !== null) {
            $t = $args['date'];
        } else
            $t = Carbon::now()->format('Y-m-d');
        $list = array();
        $result = DB::connection('mysql2')->table('visitor')->select('id', 'agent', 'last_counter', 'referred', 'ip', 'location')
            ->where('last_counter', $t)->orderBy('ID', 'DESC')->get();

        if (!$result->isEmpty()) {
            $list = self::recentVisitorPrepareData($result);
        }
        return $list;
    }

    public function recentVisitorPrepareData($result)
    {
        $list = array();
        foreach ($result as $items) {
            $item = array(
                'referred' => $items->referred !== '' ? Referred::get_referrer_link($items->referred) : '<a href= "#"> Not available</a>',
                'date' => (new Carbon($items->last_counter))->Format('M d, Y'),
            );
            $item['browser'] = array(
                'name' => $items->agent,
            );
            // Push IP
            $item['ip'] = $items->ip;

            // Push Country
            $item['country'] = array('location' => $items->location, 'name' => (new StatsCountryController())->getName($items->location));
//            $item['city'] = CountryController::get_city_name($items->ip);
            $list[] = $item;
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

    /**
     * Record Uniq Visitor Detail in DB
     *
     * @param array $arg
     * @return bool|INT
     * @throws \Exception
     */
    public static function record($arg = array())
    {
        // Define the array of defaults
        $defaults = array(
            'exclusion_match' => false,
            'exclusion_reason' => '',
        );
        $args = (new \App\Helpers\WPHelper)->my_parse_args($arg, $defaults);
        $visitor_id = 0;

        // Check User Exclusion
        if ($args['exclusion_match'] === false) {

            $user_ip = HitController::getIP();
            $user_agent = HitController::getUserAgent();

            //Check Exist This User in Current Day
            $same_visitor = self::exist_ip_in_day($user_ip);


//             If we have a new Visitor in Day
            if (!$same_visitor) {
                $visitor = array(
                    'last_counter' => Carbon::now()->format('Y-m-d'),
                    'referred' => Referred::get(),
                    'agent' => $user_agent['browser'],
                    'platform' => $user_agent['platform'],
                    'version' => $user_agent['version'],
                    'ip' => $user_ip,
                    'location' => HitController::getCountry($user_ip),
                    'user_id' => Auth::check() ? Auth::user()->id : 0,
                    'UAString' => '',
                    'hits' => 1,
                    'honeypot' => 0,
                );
                //Save Visitor TO DB
                $visitor_id = self::save_visitor($visitor);
            } else {

                DB::connection('mysql2')->table('visitor')->where('ID', $same_visitor->ID)
                    ->increment('hits', 1);
                //Get Current Visitor ID
                $visitor_id = $same_visitor->ID;


            }
        }
        if (isset($visitor_id) && $visitor_id > 0)
            return $visitor_id;
        else
            return false;
//        return (isset($visitor_id) ? $visitor_id : false);
    }

    /**
     * Save visitor relationShip
     *
     * @param $page_id
     * @param $visitor_id
     * @return int
     */
    public static function save_visitors_relationships($page_id, $visitor_id)
    {
        try {
            $insert = DB::connection('mysql2')->table('visitor_relationships')->insert([
                'visitor_id' => $visitor_id,
                'page_id' => $page_id,
                'date' => Carbon::now()->toDateTimeString()]);


        } catch (\Exception $e) {
            event(new LogErrorEvent($e->getMessage(), 'Error in visitor controller save_visitors_relationships method.'));
        }
//        return $insert;
    }

    public static function exist_ip_in_day($ip, $date = false)
    {
        $d = $date === false ? Carbon::now()->format('Y-m-d') : $date;
        $visitor = LogVisitor::where('last_counter', $d)->where('ip', $ip)->first();
        if ($visitor)
            return $visitor;
        else
            return false;
//        return (!$visitor ? false : $visitor);
    }

    public function prepareData($result): array
    {
        $list = array();
        foreach ($result as $items) {
            $item = array(
                'hits' => (int)$items->hits,
                'referred' => $items->referred !== '' ? Referred::get_referrer_link($items->referred) : '<a href= "#"> Not available</a>',
//                'refer' => $items->referred,
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
            $item['country'] = array('location' => $items->location, 'name' => (new StatsCountryController())->getName($items->location));
            $item['city'] = CountryController::get_city_name($items->ip);
            $list[] = $item;
        }
        return $list;
    }


    /**
     * Save new Visitor To DB
     *
     * @param array $visitor
     * @return INT
     */
    public static function save_visitor($visitor = array())
    {
        //TODO:here add ,more than 100 visit check

        try {
//            DB::connection('mysql2')->transaction(function () use ($visitor) {
//                return (new \App\Models\Log\LogVisitor)->updateOrCreate(
//                    ['last_counter' => $visitor['last_counter'], 'ip' => $visitor['ip']],
//                    $visitor)->id;

//                DB::connection('mysql2')->insert('insert into visitor
//    (last_counter,referred,agent,platform,version,ip,location,user_id,UAString,hits,honeypot)
//                                                                                values (?, ?)', ['john@example.com', '0']);
            DB::connection('mysql2')->statement('INSERT INTO visitor (last_counter,referred,agent,platform,version,ip,location,user_id,UAString,hits,honeypot)
                    VALUES ( ?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE hits = hits + 1',
                [$visitor['last_counter'], $visitor['referred'], $visitor['agent'], $visitor['platform'], $visitor['version'], $visitor['ip'],
                    $visitor['location'], $visitor['user_id'], $visitor['UAString'], $visitor['hits'], $visitor['honeypot']]);

//                return DB::connection('mysql2')->getpdo()->lastInsertId();


//            });
            $result = (new \App\Models\Log\LogVisitor)->select('ID')->where('ip', $visitor['ip'])->where('last_counter', $visitor['last_counter'])->first();
            return $result->ID;

        } catch (\Exception $e) {
            event(new LogErrorEvent($e->getMessage(), 'Error in visitor controller save_visitor method.'));
        } catch (\Throwable $e) {
            event(new LogErrorEvent($e->getMessage(), 'Error in visitor controller save_visitor method.'));
        }
        # Get Visitor ID

    }

}
