<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Helpers\WPHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrowserController extends Controller
{
    /**
     * Get Browser ar Chart
     *
     * @param array $arg
     * @return array
     * @throws \Exception
     */
    public static function get($arg = array())
    {

        // Set Default Params
        $defaults = array(
            'ago' => 0,
            'from' => '',
            'to' => '',
            'browser' => 'all',
        );
        $args = (new \App\Helpers\WPHelper)->my_parse_args($arg, $defaults);

        // Check Default
        if (empty($args['from']) and empty($args['to']) and $args['ago'] < 1) {
            $args['ago'] = 'all';
        }

//        // Prepare Count Day
//        if (!empty($args['from']) and !empty($args['to'])) {
//            $count_day = TimeZone::getNumberDayBetween($args['from'], $args['to']);
//        } else {
//            if (is_numeric($args['ago']) and $args['ago'] > 0) {
//                $count_day = $args['ago'];
//            } else {
//                $first_day = Helper::get_date_install_plugin();
//                $count_day = (int)TimeZone::getNumberDayBetween($first_day);
//            }
//        }
//
//        // Get time ago Days Or Between Two Days
//        if (!empty($args['from']) and !empty($args['to'])) {
//            $days_list = TimeZone::getListDays(array('from' => $args['from'], 'to' => $args['to']));
//        } else {
//            if (is_numeric($args['ago']) and $args['ago'] > 0) {
//                $days_list = TimeZone::getListDays(array('from' => TimeZone::getTimeAgo($args['ago'])));
//            } else {
//                $days_list = TimeZone::getListDays(array('from' => TimeZone::getTimeAgo($count_day)));
//            }
//        }
//
//        // Get List Of Days
//        $days_time_list = array_keys($days_list);
//        foreach ($days_list as $k => $v) {
//            $date[] = $v['format'];
//            $total_daily[$k] = 0;
//        }

        // Set Default Value
        $total = $count = $top_ten = 0;
        $BrowserVisits = $lists_value = $lists_name = $lists_keys = $lists_logo = array();

        // Check Custom Browsers or ALL Browsers
        if ($args['browser'] == "all") {
            $Browsers = (new BrowserController)->get_ua_list();

            // Get List Of Browsers
            foreach ($Browsers as $Browser) {

                //Get List Of count Visitor By Agent
                if (empty($args['from']) and empty($args['to']) and $args['ago'] == "all") {

                    // IF All Time
                    $BrowserVisits[$Browser] = (new BrowserController)->get_useragent($Browser);
                } else {

                    // IF Custom Time
                    $BrowserVisits[$Browser] = (new BrowserController)->get_useragent($Browser, $args['from'], $args['to']);
                }

                // Set All
                $total += $BrowserVisits[$Browser];
            }

            //Add Unknown Agent to total
            if (empty($args['from']) and empty($args['to']) and $args['ago'] == "all") {
                $unknown_count = DB::connection('mysql2')->table('visitor')->select(DB::raw('COUNT(*) as count'))->whereNotIn('agent',  $Browsers)->get();
            } else {
                $unknown_count = DB::connection('mysql2')->table('visitor')->select(DB::raw('COUNT(*) as count'))->whereBetween('last_counter', [$args['from'], $args['from']])->whereNotIn('agent', $Browsers)->get();
            }
            if (!$unknown_count->isEmpty())
                $unknown_count = $unknown_count[0]->count;
            $unknown_count = !is_numeric($unknown_count) ? 0 : $unknown_count;
            $total += $other_agent_count = $unknown_count;

            //Sort Browser List By Visitor ASC
            arsort($BrowserVisits);

            // Get List Of Browser
            foreach ($BrowserVisits as $key => $value) {
                $top_ten += $value;
                $count++;
                if ($count > 9) { // Max 10 Browser
                    break;
                }

                //Get Browser name
                $browser_name = self::BrowserList(strtolower($key));
                $lists_name[] = $browser_name;
                $lists_value[] = (int)$value;
                $lists_keys[] = strtolower($key);
                $lists_logo[] = self::getBrowserLogo($key);
            }

            // Push Other Browser
            if ($lists_name and $lists_value and $other_agent_count > 0) {
                $lists_name[] = 'Other';
                $lists_value[] = (int)($total - $top_ten);
            }

        } else {

            // Set Browser info
            $lists_keys[] = strtolower($args['browser']);
            $lists_logo[] = self::getBrowserLogo($args['browser']);

            // Get List Of Version From Custom Browser
//            $list = $wpdb->get_results("SELECT version, COUNT(*) as count FROM " . DB::table('visitor') . " WHERE agent = '" . $args['browser'] . "' AND `last_counter` BETWEEN '" . reset($days_time_list) . "' AND '" . end($days_time_list) . "' GROUP BY version", ARRAY_A);

            $list = DB::connection('mysql2')->table('visitor')->select(DB::raw('COUNT(*) as count'), 'version')->where('agent', $args['browser'])->whereBetween('last_counter', [$args['from'], $args['from']])->groupBy('version')->get()->toArray();

            // Sort By Count
            WPHelper::SortByKeyValue($list, 'count');

            // Get Last 20 Version that Max number
            $Browsers = array_slice($list, 0, $args['number']);

            // Push to array
            foreach ($Browsers as $l) {

                // Sanitize Version name
                $exp = explode(".", $l['version']);
                if (count($exp) > 2) {
                    $lists_name[] = $exp[0] . "." . $exp[1] . "." . substr($exp[2], 0, 3);
                } else {
                    $lists_name[] = $l['version'];
                }

                // Get List Count
                $lists_value[] = (int)$l['count'];

                // Add to Total
                $total += $l['count'];
            }
        }


        // Prepare Response
        $response = array(
//            'days'           => $count_day,
//            'from'           => reset($days_time_list),
//            'to'             => end($days_time_list),
//            'type'           => (($args['from'] != "" and $args['to'] != "") ? 'between' : 'ago'),
//            'title' => $title,
            'browsers_name' => $lists_name,
            'browsers_value' => $lists_value,
//            'info'           => array(
//                'visitor_page' => Menus::admin_url('visitors'),
//                'agent'        => $lists_keys,
//                'logo'         => $lists_logo
//            ),
            'total' => $total
        );

        // Check For No Data Meta Box
        if (count(array_filter($lists_value)) < 1 and !isset($args['no-data'])) {
            $response = array();
        }

        // Response
        return $response;
    }

    /**
     * Returns all unique user agents in the database.
     *
     * @param null $rangestartdate
     * @param null $rangeenddate
     * @return array
     */
    function get_ua_list($rangestartdate = null, $rangeenddate = null)
    {
        $d = Carbon::now()->format('Y-m-d');
        $result = DB::connection('mysql2')->table('visitor')->select(DB::raw('DISTINCT agent'));
        if ($rangestartdate != null && $rangeenddate != null) {
            if ($rangeenddate == 'CURDATE()') {
                $result = $result->whereBetween('last_counter', [$d, $rangestartdate]);
            } else {
                $result = $result->whereBetween('last_counter', [$rangestartdate, $rangeenddate]);
            }
        }
        $result = $result->get()->toArray();


//        else {
//            $result = $result
//        }

        $Browsers = array();
        $default_browser = self::BrowserList();

        foreach ($result as $out) {
            //Check Browser is defined in wp-statistics
            if (array_key_exists(strtolower($out->agent), $default_browser)) {
                $Browsers[] = $out->agent;
            }
        }

        return $Browsers;
    }

    /**
     * Count User By User Agent
     *
     * @param $agent
     * @param null $rangestartdate
     * @param null $rangeenddate
     * @return mixed
     */
    function get_useragent($agent, $rangestartdate = null, $rangeenddate = null)
    {
        $result = DB::connection('mysql2')->table('visitor')->select(DB::raw('COUNT(agent) as count'))->where('agent', $agent);
        if ($rangestartdate != null || $rangeenddate != null) {
//            if ($rangeenddate == null) {
//                $result = $result->where('last_counter','=', $rangestartdate);
////                $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(agent) FROM `" . \WP_STATISTICS\DB::table('visitor') . "` WHERE `agent` = %s AND `last_counter` = %s", $agent, $rangestartdate));
//            } else {
                $result = $result->whereBetween('last_counter', [$rangestartdate, $rangeenddate]);
//                $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(agent) FROM `" . \WP_STATISTICS\DB::table('visitor') . "` WHERE `agent` = %s AND `last_counter` BETWEEN %s AND %s", $agent, $rangestartdate, $rangeenddate));
//            }
        }

        $result = $result->get();
        if (!$result->isEmpty())
            $result = $result[0]->count;
        return !is_numeric($result) ? 0 : $result;
    }

    /**
     * Get All Browser List For Detecting
     *
     * @param bool $all
     * @area utility
     * @return array|mixed
     */
    public static function BrowserList($all = true)
    {

        //List Of Detect Browser
        $list = array(
            "chrome" => "Chrome",
            "firefox" => "Firefox",
            "msie" => "Internet Explorer",
            "edge" => "Microsoft Edge",
            "opera" => "Opera",
            "safari" => "Safari",
        );
        $browser_key = array_keys($list);

        //Return All Browser List
        if ($all === true) {
            return $list;
            //Return Browser Keys For detect
        } elseif ($all == "key") {
            return $browser_key;
        } else {
            //Return Custom Browser Name by key
            if (array_search(strtolower($all), $browser_key) !== false) {
                return $list[strtolower($all)];
            } else {
                return "Unknown";
            }
        }
    }

    /**
     * Get Browser Logo
     *
     * @param $browser
     * @return string
     */
    public static function getBrowserLogo($browser)
    {
        $name = 'unknown';
        if (array_search(strtolower($browser), self::BrowserList('key')) !== false) {
            $name = $browser;
        }
        return asset('img/browser/' . $name . '.png');
//        return WP_STATISTICS_URL . 'assets/images/browser/' . $name . '.png';
    }
}
