<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Events\LogErrorEvent;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class PageController extends Controller
{
    /**
     * Get WordPress Page Type
     */


    public static function get_page_type()
    {

        //Set Default Option
        $current_page = array("type" => "unknown", "id" => 0);

        //Check Query object
        if (isset(\request()->property) && isset(\request()->property->id)) {
            $id = \request()->property->id;
            if (is_numeric($id) and $id > 0) {
                $current_page['id'] = $id;
            }
        }

        //Home Page or Front Page
        if (self::is_home()) {
            return (new \App\Helpers\WPHelper)->my_parse_args(array("type" => "home"), $current_page);
        }


        //Property Detail Page
        if (self::is_detail_page()) {
            $current_page['type'] = "post";
        }
        //Category Page
        if (self::is_category_page_homes()) {
            $current_page['type'] = "category_homes";
        }
        if (self::is_category_page_plots()) {
            $current_page['type'] = "category_plots";
        }
        if (self::is_category_page_commercial()) {
            $current_page['type'] = "category_commercial";
        }
        if (self::is_category_page_partners()) {
            $current_page['type'] = "category_partners";
        }

        //Agency Ads Listings
        if (self::is_agency_ads()) {
            $current_page['type'] = "agency";
        }
        //is search page
        $search_query = filter_var(request()->getQueryString(), FILTER_SANITIZE_STRING);
        if (trim($search_query) != "") {
            return array("type" => "search", "id" => 0, "search_query" => $search_query);
        }

        //is 404 Page
        if (self::is_404()) {
            $current_page['type'] = "404";
        }

        // Add WordPress Login Page
        if (self::is_login_page()) {
            $current_page['type'] = "loginpage";
        }
        if (self::is_cities_listing()) {
            $current_page['type'] = "city_listing";
        }

        return $current_page;
    }

    /**
     * Record Page in Database
     */
    public static function record()
    {
        // Get Current Page
        $current_page = self::get_page_type();

        // If we didn't find a page id, we don't have anything else to do.
        if ($current_page['type'] == "unknown" || !isset($current_page['id'])) {
            return false;
        }

        // Get Page uri
        $page_uri = self::sanitize_page_uri();

        $d = Carbon::now()->format('Y-m-d');

        // escape uri
//        $esc_uri = DB::connection('mysql2')->getPdo()->quote(strip_tags($page_uri));

        $esc_uri = $page_uri;

        // Check if we have already been to this page today.
//        $exist = $wpdb->get_row(
//            "SELECT `page_id` FROM `" . DB::table('pages') . "` WHERE `date` = '" . TimeZone::getCurrentDate('Y-m-d') . "' " .
//            (array_key_exists("search_query", $current_page) === true ? "AND `uri` = '" . esc_sql($page_uri) . "'" : "") .
//            "AND `type` = '{$current_page['type']}' AND `id` = {$current_page['id']}", ARRAY_A);
//        dd($page_uri, $page_uri);

        $sql = DB::connection('mysql2')->table('pages')->select('page_id', 'uri')
            ->where('date', $d);
        if (array_key_exists("search_query", $current_page) === true) {
            $sql = $sql->where('uri', $esc_uri);
        } elseif ($current_page['type'] == 'agency' || $current_page['type'] == 'city_listing') {
            $sql = $sql->where('uri', $esc_uri);
        }

        $exist = $sql->where('type', $current_page['type'])->where('id', $current_page['id'])->first();


        // Update Exist Page
        if ($exist) {
//            DB::connection('mysql2')->transaction(function () use ($exist) {
                DB::connection('mysql2')->table('pages')->where('page_id', $exist->page_id)
                    ->increment('count');
//            });

            $page_id = $exist->page_id;

        } else {

            // Prepare Pages Data
            $pages = array(
                'uri' => $page_uri,
                'date' => $d,
                'count' => 1,
                'id' => $current_page['id'],
                'type' => $current_page['type']
            );
            // Added to DB
            $page_id = self::save_page($pages);
        }


        return (isset($page_id) ? $page_id : false);
    }

    /**
     * Add new row to Pages Table
     *
     * @param array $page
     * @return int
     */
    public static function save_page($page = array())
    {
        # Add Filter Insert ignore
        try {
                return DB::connection('mysql2')->table('pages')->insertGetId($page,'page_id');

        } catch (\Exception $e) {
            event(new LogErrorEvent($e->getMessage(), 'Error in page controller save_page method.'));

        }
//        catch (\Throwable $e) {
//            event(new LogErrorEvent($e->getMessage(), 'Error in page controller save_page method.'));
//        }


        # Get Page ID
//        $page_id = $insert;

        # Remove ignore filter
//        remove_filter('query', array('\WP_STATISTICS\DB', 'insert_ignore'), 10);

        # Do Action After Save New Visitor
//        do_action('wp_statistics_save_page', $page_id, $page);

//        return $page_id;
    }


    public static function is_home()
    {
        return Route::current()->getName() == 'home';
//        return $data_args['route-name'] == 'home';
    }

    public static function is_detail_page()
    {
        return isset(\request()->property) && isset(\request()->property->id);
    }

    /*
     * if uri is in array
    ['/all_cities/pakistan/homes','all_cities/pakistan/plots','/all_cities/pakistan/commercial','/partners']
    return true
    **/
    public static function is_category_page_homes()
    {
        $url = 'all_cities/pakistan/homes';
        return \request()->url() == \url('/') . '/' . $url;
    }

    public static function is_category_page_plots()
    {
        $url = 'all_cities/pakistan/plots';
        return \request()->url() == \url('/') . '/' . $url;
    }

    public static function is_category_page_commercial()
    {
        $url = 'all_cities/pakistan/commercial';
        return \request()->url() == \url('/') . '/' . $url;
    }

    public static function is_category_page_partners()
    {
        $url = 'partners';
        return \request()->url() == \url('/') . '/' . $url;
    }


    public static function is_agency_ads(): bool
    {
        return Route::current()->getName() === 'agents.ads.listing';

    }

    public static function is_404()
    {
        return http_response_code() === 404;
    }

    public static function is_login_page()
    {
        return Route::current()->getName() == 'login';
    }

    public static function is_cities_listing()
    {
        return Route::current()->getName() == 'cities.listings';
    }

    /**
     * Get Page Url
     *
     * @return bool|mixed|string
     */
    public static function get_page_uri()
    {

        // Get the site's path from the URL.
        $site_uri = parse_url(url('/'), PHP_URL_PATH);
        $site_uri_len = strlen($site_uri);

        // Get the site's path from the URL.
        $home_uri = parse_url(url('/'), PHP_URL_PATH);
        $home_uri_len = strlen($home_uri);

        // Get the current page URI.
        $page_uri = $_SERVER["REQUEST_URI"];

        /*
         * We need to check which URI is longer in case one contains the other.
         * For example home_uri might be "/site/wp" and site_uri might be "/site".
         * In that case we want to check to see if the page_uri starts with "/site/wp" before
         * we check for "/site", but in the reverse case, we need to swap the order of the check.
         */
        if ($site_uri_len > $home_uri_len) {
            if (substr($page_uri, 0, $site_uri_len) == $site_uri) {
                $page_uri = substr($page_uri, $site_uri_len);
            }

            if (substr($page_uri, 0, $home_uri_len) == $home_uri) {
                $page_uri = substr($page_uri, $home_uri_len);
            }
        } else {
            if (substr($page_uri, 0, $home_uri_len) == $home_uri) {
                $page_uri = substr($page_uri, $home_uri_len);
            }

            if (substr($page_uri, 0, $site_uri_len) == $site_uri) {
                $page_uri = substr($page_uri, $site_uri_len);
            }
        }

        //Sanitize Xss injection
        $page_uri = filter_var($page_uri, FILTER_SANITIZE_STRING);

        // If we're at the root (aka the URI is blank), let's make sure to indicate it.
        if ($page_uri == '') {
            $page_uri = '/';
        }

        return $page_uri;
    }

    /**
     * Sanitize Page Url For Push to Database
     */
    public static function sanitize_page_uri()
    {

        // Get Current WordPress Page
        $current_page = self::get_page_type();

        // Get the current page URI.
        $page_uri = self::get_page_uri();

        // Get String Search Wordpress
        if (array_key_exists("search_query", $current_page) and !empty($current_page["search_query"])) {
            $base_url = \url('/') . '/';

            $full_url = str_replace($base_url, '', \request()->url());
            if ($full_url !== '') {
                $page_uri = '/' . $full_url . '?' . $current_page['search_query'];
            } else
                $page_uri = "?s=" . $current_page['search_query'];
        }

        // Sanitize for WordPress Login Page
        if ($current_page['type'] == "loginpage") {
            $page_uri = self::RemoveQueryStringUrl($page_uri);
        }

        // Check Strip Url Parameter
//        if (Option::get('strip_uri_parameters') and array_key_exists("search_query", $current_page) === false) {
//            $temp = explode('?', $page_uri);
//            if ($temp !== false) {
//                $page_uri = $temp[0];
//            }
//        }

        // Limit the URI length to 255 characters, otherwise we may overrun the SQL field size.
        return substr($page_uri, 0, 255);
    }

    /**
     * Remove Query String From Url
     *
     * @param $url
     * @return bool|string
     */
    public static function RemoveQueryStringUrl($url)
    {
        return substr($url, 0, strrpos($url, "?"));
    }

}
