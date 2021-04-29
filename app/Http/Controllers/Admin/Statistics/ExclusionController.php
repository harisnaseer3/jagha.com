<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Classes\Robots;
use App\Events\LogErrorEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HitRecord\HitController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Jaybizzle\CrawlerDetect\CrawlerDetect;


class ExclusionController extends Controller
{
    /**
     * Get Exclusion List
     *
     * @return array
     */
    public static function exclusion_list()
    {
        return array(
            'CrawlerDetect' => 'Crawler Detect',
            'robot' => 'Robot',
            'BrokenFile' => 'Broken Link',
            'self referral' => 'Self Referral',
            '404' => '404',
        );
    }

    public static function check()
    {

        // Create Default Object
        $exclude = array('exclusion_match' => false, 'exclusion_reason' => '');

        // Get List Of Exclusion
        $exclusion_list = array_keys(self::exclusion_list());

        // Check Exclusion
        foreach ($exclusion_list as $list) {
            $method = 'exclusion_' . strtolower(str_replace(array("-", " "), "_", $list));
            $check = self::{$method}();
            if ($check === true) {
                $exclude = array('exclusion_match' => true, 'exclusion_reason' => $list);
                break;
            }
        }

        return $exclude;
    }
    /**
     * Record Exclusion in DB.
     *
     * @param array $exclusion
     */
    public static function record($exclusion = array())
    {

        // Check Exist this Exclusion in this day
        $d = Carbon::now()->format('Y-m-d');
        try {
            $data = DB::connection('mysql2')->table('exclusions')->select('ID')
                ->where('date', $d)
                ->where('reason', $exclusion['exclusion_reason'])
                ->first();
            if ($data) {
                DB::connection('mysql2')->table('exclusions')
                    ->where('ID', $data->ID)
                    ->increment('count');
            } else {
                DB::connection('mysql2')->table('exclusions')
                    ->insert([
                        'date' => $d,
                        'reason' => $exclusion['exclusion_reason'],
                        'count' => 1,
                    ]);
            }
        } catch (\Exception $e) {
            event(new LogErrorEvent($e->getMessage(), 'Error in exclusion controller record method.'));

        }
    }

    /**
     * Detect if  404 Page.
     */
    public static function exclusion_404()
    {
        return Route::current() == null;
    }

    public static function exclusion_crawlerdetect()
    {
        $CrawlerDetect = new CrawlerDetect;
        if ($CrawlerDetect->isCrawler()) {
            return true;
        }

        return false;
    }

    /**
     * Detect if Self Referral WordPress.
     */
//    public static function exclusion_self_referral()
//    {
//        //TODO:check its value
//        return $_SERVER['HTTP_USER_AGENT'] == env('APP_URL');
//    }


    /**
     * Detect if Broken Link.
     */
    public static function exclusion_brokenfile()
    {
        // Check is 404
        if (http_response_code() == 404) {

            //Check Current Page
//            if (isset($_SERVER["HTTP_HOST"]) and isset($_SERVER["REQUEST_URI"])) {
            $http_host = \request()->server('HTTP_HOST');
            $request_uri= \request()->server('REQUEST_URI');
            $server_https = $_SERVER['HTTPS'];
            if (isset($http_host) and isset($request_uri)) {
                //Get Full Url Page
                $page_url = (isset($server_https) && $server_https === 'on' ? "https" : "http") . "://{$http_host}{$request_uri}";

                //Check Link file
                $page_url = parse_url($page_url, PHP_URL_PATH);
                $ext = pathinfo($page_url, PATHINFO_EXTENSION);
                if (!empty($ext) and $ext != 'php') {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Detect if Robots.
     */
    public static function exclusion_robot()
    {

        // Pull the robots from the database.
        $robots = Robots::get();

        // Check to see if we match any of the robots.
        foreach ($robots as $robot) {
            $robot = trim($robot);

            // If the match case is less than 4 characters long, it might match too much so don't execute it.
            if (strlen($robot) > 3) {
                if (stripos(\request()->server('HTTP_USER_AGENT'), $robot) !== false) {
                    return true;
                }
            }
        }

        // Check User IP is empty Or Not User Agent
//        if (Option::get('corrupt_browser_info')) {
        if (\request()->server('HTTP_USER_AGENT') == '' || (new HitController)->getIP() == '0.0.0.0') {
            return true;
        }

        return false;
    }

    /**
     * Detect if GEO-IP include Or Exclude Country.
     *
     * @throws \Exception
     */
//    public static function exclusion_geoip()
//    {
//
//        // Get User Location
//        $location = GeoIP::getCountry();
//
//        // Grab the excluded/included countries lists, force the country codes to be in upper case to match what the GeoIP code uses.
//        $excluded_countries = explode("\n", strtoupper(str_replace("\r\n", "\n", Option::get('excluded_countries'))));
//        $included_countries_string = trim(strtoupper(str_replace("\r\n", "\n", Option::get('included_countries'))));
//
//        // We need to be really sure this isn't an empty string or explode will return an array with one entry instead of none.
//        if ($included_countries_string == '') {
//            $included_countries = array();
//        } else {
//            $included_countries = explode("\n", $included_countries_string);
//        }
//
//        // Check to see if the current location is in the excluded countries list.
//        if (in_array($location, $excluded_countries)) {
//            return true;
//        } // Check to see if the current location is not the included countries list.
//        else if (!in_array($location, $included_countries) && count($included_countries) > 0) {
//            return true;
//        }
//
//        return false;
//    }

    /**
     * Detect if Exclude Host name.
     */
//    public static function exclusion_hostname()
//    {
//        global $WP_Statistics;
//
//        // Get Host name List
//        $excluded_host = explode("\n", Option::get('excluded_hosts'));
//
//        // If there's nothing in the excluded host list, don't do anything.
//        if (count($excluded_host) > 0) {
//            $transient_name = 'wps_excluded_hostname_to_ip_cache';
//
//            // Get the transient with the hostname cache.
//            $hostname_cache = get_transient($transient_name);
//
//            // If the transient has expired (or has never been set), create one now.
//            if ($hostname_cache === false) {
//                // Flush the failed cache variable.
//                $hostname_cache = array();
//
//                // Loop through the list of hosts and look them up.
//                foreach ($excluded_host as $host) {
//                    if (strpos($host, '.') > 0) {
//                        $hostname_cache[$host] = gethostbyname($host . '.');
//                    }
//                }
//
//                // Set the transient and store it for 1 hour.
//                set_transient($transient_name, $hostname_cache, 360);
//            }
//
//            // Check if the current IP address matches one of the ones in the excluded hosts list.
//            if (in_array($WP_Statistics->ip, $hostname_cache)) {
//                return true;
//            }
//        }
//
//        return false;
//    }

}
